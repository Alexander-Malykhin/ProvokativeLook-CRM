<?php

namespace ProvokativeLook\Tests\Application\Deal\Service;

use PHPUnit\Framework\TestCase;
use ProvokativeLook\Application\Deal\Service\DealUpdateService;
use ProvokativeLook\Application\Deal\Stage\Contracts\StageHandlerInterface;
use ProvokativeLook\Application\Deal\Stage\Contracts\StageHandlerRegistryInterface;
use ProvokativeLook\Domain\Entity\Deal;
use ProvokativeLook\Domain\Entity\Contracts\CrmItemInterface;
use ProvokativeLook\Infrastructure\Repository\Contracts\DealRepositoryInterface;

final class DealUpdateServiceTest extends TestCase
{
    private function makeDealWithStage(string $stageId): Deal
    {
        $item = $this->createMock(CrmItemInterface::class);
        $item->method('get')->with('STAGE_ID')->willReturn($stageId);
        return new Deal($item);
    }

    public function testHandleDoesNothingWhenDealNotFound(): void
    {
        $repo = $this->createMock(DealRepositoryInterface::class);
        $repo->method('getItem')->with(123)->willReturn(null);

        $registry = $this->createMock(StageHandlerRegistryInterface::class);
        $registry->expects($this->never())->method('get');

        (new DealUpdateService($repo, $registry))->handle(123);

        $this->assertTrue(true);
    }

    public function testHandleDoesNothingWhenNoHandlerForStage(): void
    {
        $deal = $this->makeDealWithStage('NEW');

        $repo = $this->createMock(DealRepositoryInterface::class);
        $repo->method('getItem')->with(10)->willReturn($deal);

        $registry = $this->createMock(StageHandlerRegistryInterface::class);
        $registry->method('get')->with('NEW')->willReturn(null);

        (new DealUpdateService($repo, $registry))->handle(10);

        $this->assertTrue(true);
    }

    public function testHandleCallsHandlerWhenFound(): void
    {
        $deal = $this->makeDealWithStage('NEW');

        $handler = $this->createMock(StageHandlerInterface::class);
        $handler->expects($this->once())->method('handle')->with($deal);

        $repo = $this->createMock(DealRepositoryInterface::class);
        $repo->method('getItem')->with(99)->willReturn($deal);

        $registry = $this->createMock(StageHandlerRegistryInterface::class);
        $registry->method('get')->with('NEW')->willReturn($handler);

        (new DealUpdateService($repo, $registry))->handle(99);
    }
}