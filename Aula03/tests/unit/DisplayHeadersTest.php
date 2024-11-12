<?php

use Headers\DisplayHeaders;
use Headers\Interfaces\HeaderStringInterface;
use Headers\Response\Cookie;
use Headers\Response\Exceptions\EmptyHttpHeadersException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(DisplayHeaders::class)]
final class DisplayHeadersTest extends PHPUnit\Framework\TestCase
{
    public static function positiveHeadersDataProvider(): array
    {
        return [
            [
                'Set-Cookie: name=valor',
                'Content-Type: text/html; charset=utf-8',
                <<<HEADER
                Set-Cookie: name=valor
                Content-Type: text/html; charset=utf-8
                HEADER
            ],
            [
                'Set-Cookie: maisumcampo=valor12345',
                'Content-Type: multipart/form-data; boundary=something',
                <<<HEADER
                Set-Cookie: maisumcampo=valor12345
                Content-Type: multipart/form-data; boundary=something
                HEADER
            ],
            [
                'Set-Cookie: maisumcampo=valor12345',
                'Content-Type: text/html; charset=utf-8',
                <<<HEADER
                Set-Cookie: maisumcampo=valor12345
                Content-Type: text/html; charset=utf-8
                HEADER
            ]
        ];
    }

    #[DataProvider('positiveHeadersDataProvider')]
    public function testDisplayHeadersComponentShouldDisplayHeadersAsString($cookieHeaderString, $contentHeaderString, $expect)
    {
        $displayHeaders = new DisplayHeaders();

        $cookieStub = \Mockery::mock(Cookie::class);
        $cookieStub->allows()
                   ->getHeaderString()
                   ->andReturn($cookieHeaderString)
        ;

        $contentStub = \Mockery::mock(HeaderStringInterface::class);
        $contentStub->allows()
                   ->getHeaderString()
                   ->andReturn($contentHeaderString)
        ;

        $displayHeaders->add($cookieStub);
        $displayHeaders->add($contentStub);

        $result = $displayHeaders->getHeaderString();
        $this->assertEquals($expect, $result);
    }

    #[DataProvider('positiveHeadersDataProvider')]
    public function testDisplayHeaderShouldDisplayHearsInsideAFile($cookieHeaderString, $contentHeaderString, $expect)
    {
        $cookieStub = \Mockery::mock(Cookie::class, ['getHeaderString' => $cookieHeaderString]);
        $contentStub = \Mockery::mock(HeaderStringInterface::class, ['getHeaderString' => $contentHeaderString]);

        $displayHeaders = new DisplayHeaders();
        $displayHeaders->add($cookieStub);
        $displayHeaders->add($contentStub);

        $displayHeaders->displayInFile('output.txt');

        $this->assertStringEqualsFile('output.txt', "HTTP/1.1 200 OK" . PHP_EOL . $expect);
    }

    public function testDisplayHeadersWithoutHeadersShouldThrowAnException()
    {
        $this->expectException(EmptyHttpHeadersException::class);
        
        $displayHeaders = new DisplayHeaders();
        $displayHeaders->getHeaderString();
    }

    protected function setUp(): void
    {
        chdir('tests/unit');
        file_put_contents('output.txt', "HTTP/1.1 200 OK\n");
    }

    public function tearDown(): void
    {
        unlink('output.txt');
        \Mockery::close();
    }
}
