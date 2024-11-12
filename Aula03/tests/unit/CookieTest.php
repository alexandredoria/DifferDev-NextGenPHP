<?php

use Headers\Response\Cookie;
use Headers\Response\Expires;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(Cookie::class)]
final class CookieTest extends PHPUnit\Framework\TestCase
{
    public static function positiveCookieDataProvider(): array
    {
        return [
            ['attribute', 'value', 'Set-Cookie: attribute=value'],
            ['attribute', 'a value with spaces', 'Set-Cookie: attribute=a+value+with+spaces'],
            ['mycookie', 'meu valor com espaço', 'Set-Cookie: mycookie=meu+valor+com+espa%C3%A7o'],
            ['complex', 'teste ()/\\$#*&}}{_-', 'Set-Cookie: complex=teste+%28%29%2F%5C%24%23%2A%26%7D%7D%7B_-'],
            ['attribute', '  value  ', 'Set-Cookie: attribute=value'],
            ['  attribute  ', 'value', 'Set-Cookie: attribute=value'],
        ];
    }

    #[DataProvider('positiveCookieDataProvider')]
    public function testCookieComponentShouldReturnCookieHeaderString(
        string $cookieName,
        string $cookieValue,
        string $expect
    ) {
        $cookie = new Cookie($cookieName, $cookieValue);
        $result = $cookie->getHeaderString();
        $this->assertEquals($expect, $result);
    }

    public static function negativeCookieDataProvider(): array
    {
        return [
            ['aço', 'valor aqui'],
            ['primário', 'valor aqui'],
            ['campo espaco', 'valor aqui'],
            ['campo espaço mais', 'valor aqui']
        ];
    }

    #[DataProvider('negativeCookieDataProvider')]
    public function testCookieComponeteShouldNotAcceptWrongName(
        string $cookieName,
        string $cookieValue
    ) {
        $this->expectException(InvalidArgumentException::class);
        $cookie = new Cookie($cookieName, $cookieValue);
    }

    public static function positiveCookieExpiresDataProvider(): array
    {
        return require 'fixture/DataProviders/positiveCookieExpires.php';
    }

    public static function positiveCookieAttributesDataProvider(): array
    {
        return require 'fixture/DataProviders/positiveCookieAttributes.php';
    }

    public static function negativeCookieAttributesDataProvider(): array
    {
        return require 'fixture/DataProviders/negativeCookieAttributes.php';
    }

    #[DataProvider('positiveCookieExpiresDataProvider')]
    public function testCookieComponentShouldReturnExpiresAttribute(
        string $cookieName,
        string $cookieValue,
        string $startDate,
        string $expireInterval,
        string $expect
    ) {
        $expiresMock = \Mockery::mock(Expires::class);

        $expiresMock->expects()
                    ->get()
                    ->andReturn($expireInterval)
                ;
        
        $expiresMock->shouldReceive('hours', 'minutes')
                    ->andReturn($expiresMock)
                ;

        $cookie = new Cookie($cookieName, $cookieValue);

        $cookie->setExpires(
            new DateTimeImmutable($startDate),
            $expiresMock
        );

        $result = $cookie->getHeaderString();
        
        $this->assertEquals(
            $expect,
            $result
        );
    }

    #[DataProvider('positiveCookieAttributesDataProvider')]
    public function testCookieComponentShouldReturnOthersAttributes(
        array $data,
        string $expect
    ) {

        $cookie = new Cookie($data['name'], $data['value']);

        foreach ($data as $attribute => $value) {
            switch ($attribute) {
                case 'path': $cookie->setPath($value); break;
                case 'domain': $cookie->setDomain($value); break;
                case 'maxAge': $cookie->setMaxAge($value); break;
                case 'sameSite': $cookie->setSameSite($value); break;
                case 'httpOnly': $cookie->setHttpOnly(); break;
                case 'partitioned': $cookie->setPartitioned(); break;
                case 'secure': $cookie->setSecure(); break;
            }
        }

        $result = $cookie->getHeaderString();
        
        $this->assertEquals(
            $expect,
            $result
        );
    }

    #[DataProvider('negativeCookieAttributesDataProvider')]
    public function testCookieComponentShouldThrowInvalidArgumentException(
        array $data
    ) {
        $this->expectException(InvalidArgumentException::class);
        $cookie = new Cookie($data['name'], $data['value']);

        foreach ($data as $attribute => $value) {
            switch ($attribute) {
                case 'path': $cookie->setPath($value); break;
                case 'domain': $cookie->setDomain($value); break;
                case 'maxAge': $cookie->setMaxAge($value); break;
                case 'sameSite': $cookie->setSameSite($value); break;
                case 'httpOnly': $cookie->setHttpOnly(); break;
                case 'partitioned': $cookie->setPartitioned(); break;
                case 'secure': $cookie->setSecure(); break;
            }
        }
    }

    protected function tearDown(): void
    {
        \Mockery::close();
    }
}