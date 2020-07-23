<?php

namespace Phpactor\LanguageServer\Tests\Unit\Handler\System;

use Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor\LanguageServer\Core\Server\RpcClient;
use Phpactor\LanguageServer\Core\Service\ServiceManager;
use Phpactor\LanguageServer\Handler\System\ServiceHandler;
use Phpactor\LanguageServer\Tests\Unit\Handler\HandlerTestCase;
use Prophecy\Argument;

class ServiceHandlerTest extends HandlerTestCase
{
    /**
     * @var ObjectProphecy
     */
    private $serviceManager;

    /**
     * @var RpcClient
     */
    private $serverClient;

    /**
     * @var ServiceHandler
     */
    private $serviceHandler;

    protected function setUp(): void
    {
        $this->serviceManager = $this->prophesize(ServiceManager::class);
        $this->serverClient = $this->prophesize(RpcClient::class);
    }

    public function handler(): Handler
    {
        return new ServiceHandler(
            $this->serviceManager->reveal(),
            $this->serverClient->reveal()
        );
    }

    public function testItStartsAService(): void
    {
        $this->serviceManager->start('foobar')->shouldBeCalled();

        $this->dispatch('service/start', [
            'name' => 'foobar'
        ]);
    }

    public function testItStopsAService()
    {
        $this->serviceManager->stop('foobar')->shouldBeCalled();
        $this->dispatch('service/stop', [
            $this->serviceManager->reveal(),
            'name' => 'foobar'
        ]);
    }

    public function testReturnsRunningServices()
    {
        $this->serviceManager->runningServices()->willReturn([
            'one', 'two'
        ]);
        $this->serverClient->notification('window/showMessage', Argument::cetera())->shouldBeCalled();

        $this->dispatch('service/running', [
            $this->serviceManager->reveal(),
            $this->serverClient->reveal(),
            'name' => 'foobar'
        ]);
    }
}
