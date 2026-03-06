<?php

namespace ProvokativeLook\Tests\EventHandler\Deal;

use PHPUnit\Framework\TestCase;
use ProvokativeLook\EventHandler\Deal\DealUpdate;
use ProvokativeLook\Application\Common\Contracts\IdHandlerInterface;

final class DealUpdateTest extends TestCase
{
    protected function tearDown(): void
    {
        DealUpdate::$factory = null;
    }

    public function testDoesNothingWhenNoId(): void
    {
        $called = false;

        DealUpdate::$factory = function () use (&$called) {
            $called = true;
            return $this->createMock(IdHandlerInterface::class);
        };

        $fields = [];
        DealUpdate::onAfterUpdate($fields);

        $this->assertFalse($called);
    }

    public function testCallsServiceHandleWithDealId(): void
    {
        $service = $this->createMock(IdHandlerInterface::class);
        $service->expects($this->once())->method('handle')->with(123);

        DealUpdate::$factory = fn() => $service;

        $fields = ['ID' => 123];
        DealUpdate::onAfterUpdate($fields);
    }
}