<?php

namespace ProvokativeLook\Tests\EventHandler\Deal;

use PHPUnit\Framework\TestCase;
use ProvokativeLook\EventHandler\Deal\DealProductRowsSave;
use ProvokativeLook\Application\Common\Contracts\IdHandlerInterface;

final class DealProductRowsSaveTest extends TestCase
{
    protected function tearDown(): void
    {
        DealProductRowsSave::$factory = null;
    }

    public function testDoesNothingWhenInvalidId(): void
    {
        $called = false;

        DealProductRowsSave::$factory = function () use (&$called) {
            $called = true;
            return $this->createMock(IdHandlerInterface::class);
        };

        DealProductRowsSave::onAfterSave(0, []);

        $this->assertFalse($called);
    }

    public function testCallsServiceHandle(): void
    {
        $service = $this->createMock(IdHandlerInterface::class);
        $service->expects($this->once())->method('handle')->with(17);

        DealProductRowsSave::$factory = fn() => $service;

        DealProductRowsSave::onAfterSave(17, []);
    }
}