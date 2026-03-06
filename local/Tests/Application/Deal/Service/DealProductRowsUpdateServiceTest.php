<?php

namespace ProvokativeLook\Tests\Application\Deal\Service;

use PHPUnit\Framework\TestCase;
use ProvokativeLook\Application\Deal\Service\DealProductRowsUpdateService;
use ProvokativeLook\Application\Deal\Stage\Contracts\StageHandlerInterface;
use ProvokativeLook\Application\Deal\Stage\Contracts\StageHandlerRegistryInterface;
use ProvokativeLook\Domain\Entity\Deal;
use ProvokativeLook\Domain\Entity\Contracts\CrmItemInterface;
use ProvokativeLook\Infrastructure\Repository\Contracts\DealRepositoryInterface;

final class DealProductRowsUpdateServiceTest extends TestCase
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
        $repo->method('getItem')->with(1)->willReturn(null);

        $registry = $this->createMock(StageHandlerRegistryInterface::class);
        $registry->expects($this->never())->method('get');

        (new DealProductRowsUpdateService($repo, $registry))->handle(1);

        $this->assertTrue(true);
    }

    public function testHandleDoesNothingWhenNoHandler(): void
    {
        $deal = $this->makeDealWithStage('PREPARATION');

        $repo = $this->createMock(DealRepositoryInterface::class);
        $repo->method('getItem')->with(2)->willReturn($deal);

        $registry = $this->createMock(StageHandlerRegistryInterface::class);
        $registry->method('get')->with('PREPARATION')->willReturn(null);

        (new DealProductRowsUpdateService($repo, $registry))->handle(2);

        $this->assertTrue(true);
    }

    public function testHandleCallsHandler(): void
    {
        $deal = $this->makeDealWithStage('PREPARATION');

        $handler = $this->createMock(StageHandlerInterface::class);
        $handler->expects($this->once())->method('handle')->with($deal);

        $repo = $this->createMock(DealRepositoryInterface::class);
        $repo->method('getItem')->with(3)->willReturn($deal);

        $registry = $this->createMock(StageHandlerRegistryInterface::class);
        $registry->method('get')->with('PREPARATION')->willReturn($handler);

        (new DealProductRowsUpdateService($repo, $registry))->handle(3);
    }
}