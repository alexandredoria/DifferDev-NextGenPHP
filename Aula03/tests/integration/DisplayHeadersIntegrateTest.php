<?php

use Headers\DisplayHeaders;
use Headers\Response\Cookie;
use Headers\Response\Expires;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(DisplayHeaders::class)]
#[CoversClass(Cookie::class)]
#[CoversClass(Expires::class)]
final class DisplayHeadersIntegrateTest extends PHPUnit\Framework\TestCase
{
    public static function positiveCookieDataProvider(): array
    {
        return [
            [
                'cookies' => [
                    ['name' => 'name1', 'value' => 'value123456'],
                    ['name' => 'name2', 'value' => 'value678912332', 'startDate' => '2023-02-06 13:00:00', 'expiresIn' => '2 hours|20 minutes|38 seconds'],
                ],
                'expect' => 
                    <<<HEADER
                    Set-Cookie: name1=value123456
                    Set-Cookie: name2=value678912332; Expires=Mon, 06 Feb 2023 15:20:38 GMT
                    HEADER
            ],
            [
                'cookies' => [
                    ['name' => 'name1', 'value' => 'value123456', 'startDate' => '2023-02-06 13:00:00', 'expiresIn' => '1 days|2 hours|42 minutes|29 seconds'],
                    ['name' => 'name2', 'value' => 'value678912332', 'startDate' => '2023-02-06 13:00:00', 'expiresIn' => '2 hours|20 minutes|38 seconds'],
                ],
                'expect' => 
                    <<<HEADER
                    Set-Cookie: name1=value123456; Expires=Tue, 07 Feb 2023 15:42:29 GMT
                    Set-Cookie: name2=value678912332; Expires=Mon, 06 Feb 2023 15:20:38 GMT
                    HEADER
            ],
            [
                'cookies' => [
                    ['name' => 'name1', 'value' => 'value123456', 'startDate' => '2023-02-06 13:00:00', 'expiresIn' => '1 days|2 hours|42 minutes|29 seconds'],
                    ['name' => 'name2', 'value' => 'value678912332', 'startDate' => '2023-02-06 13:00:00', 'expiresIn' => '2 hours|20 minutes|38 seconds'],
                    ['name' => 'name3', 'value' => 'valueqwee12334', 'startDate' => '2023-02-06 13:00:00', 'expiresIn' => '1 hours|30 minutes|22 seconds'],
                ],
                'expect' => 
                    <<<HEADER
                    Set-Cookie: name1=value123456; Expires=Tue, 07 Feb 2023 15:42:29 GMT
                    Set-Cookie: name2=value678912332; Expires=Mon, 06 Feb 2023 15:20:38 GMT
                    Set-Cookie: name3=valueqwee12334; Expires=Mon, 06 Feb 2023 14:30:22 GMT
                    HEADER
            ]
        ];
    }

    #[DataProvider('positiveCookieDataProvider')]
    public function testDisplayHeadersShouldIntegrateWithMultipleCookies($cookies, $expect)
    {
        $displayHeaders = new DisplayHeaders();

        foreach ($cookies as $cookie) {
            $cookieComponent = new Cookie($cookie['name'], $cookie['value']);
            
            if ($cookie['startDate'] && $cookie['expiresIn']){
                $expiresComponent = new Expires();

                $intervals = explode('|', $cookie['expiresIn']);
                
                foreach ($intervals as $interval) {
                    [$value, $method] = explode(' ', $interval);

                    $expiresComponent->$method((int) $value);
                }

                $startDate = new DateTimeImmutable($cookie['startDate']);
                $cookieComponent->setExpires($startDate, $expiresComponent);
            }

            $displayHeaders->add($cookieComponent);
        }
        
        $result = $displayHeaders->getHeaderString();

        $this->assertEquals($expect, $result);
    }
}
