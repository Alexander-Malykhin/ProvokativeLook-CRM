<?php

namespace ProvokativeLook\Tests\Application\Deal\Stage\New;

use PHPUnit\Framework\TestCase;
use ProvokativeLook\Application\Deal\Stage\New\UpdateProductStatsHandler;
use ProvokativeLook\Domain\Entity\Deal;
use ProvokativeLook\Domain\Entity\Contracts\CrmItemInterface;
use ProvokativeLook\Infrastructure\Repository\Contracts\ProductRepositoryInterface;

final class UpdateProductStatsHandlerTest extends TestCase
{
    private function makeDeal(int $id): Deal
    {
        $item = $this->createMock(CrmItemInterface::class);
        $item->method('get')->willReturnMap([
            ['ID', $id],
            ['STAGE_ID', 'NEW'],
        ]);

        return new Deal($item);
    }

    public function testStageId(): void
    {
        $repo = $this->createMock(ProductRepositoryInterface::class);
        $handler = new UpdateProductStatsHandler($repo);

        $this->assertSame('NEW', $handler->stageId());
    }

    public function testHandleDoesNothingWhenNoRows(): void
    {
        $repo = $this->createMock(ProductRepositoryInterface::class);
        $repo->method('fetchForDeal')->with(10)->willReturn([]);

        $deal = $this->makeDeal(10);

        $handler = new UpdateProductStatsHandler($repo);
        $handler->handle($deal);

        $this->assertTrue(true);
    }
}