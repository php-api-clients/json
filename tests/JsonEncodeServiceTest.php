<?php declare(strict_types=1);

namespace ApiClients\Tests\Tools\Json;

use ApiClients\Tools\Json\JsonEncodeService;
use ApiClients\Tools\TestUtilities\TestCase;
use ExceptionalJSON\EncodeErrorException;
use React\EventLoop\Factory;
use function Clue\React\Block\await;

class JsonEncodeServiceTest extends TestCase
{
    public function testHandler()
    {
        $loop = Factory::create();
        $handler = new JsonEncodeService($loop);
        self::assertSame('[]', await($handler->encode([]), $loop));
    }

    public function testFailure()
    {
        $this->expectException(EncodeErrorException::class);
        $this->expectExceptionMessage('Malformed UTF-8 characters, possibly incorrectly encoded');

        $loop = Factory::create();
        $handler = new JsonEncodeService($loop);
        await($handler->encode(["\xB1\x31"]), $loop);
    }
}
