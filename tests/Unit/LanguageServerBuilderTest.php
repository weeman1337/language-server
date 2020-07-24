<?php

namespace Phpactor\LanguageServer\Tests\Unit;

use Phpactor\LanguageServer\Core\Dispatcher\Factory\ClosureDispatcherFactory;
use Phpactor\TestUtils\PHPUnit\TestCase;
use Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor\LanguageServer\Core\Server\LanguageServer;
use Phpactor\LanguageServer\LanguageServerBuilder;
use Psr\Log\NullLogger;

class LanguageServerBuilderTest extends TestCase
{
    public function testBuild(): void
    {
        $server = LanguageServerBuilder::create(new ClosureDispatcherFactory(function () {
        }))
            ->tcpServer('127.0.0.1:8888')
            ->build();

        $this->assertInstanceOf(LanguageServer::class, $server);
    }
}
