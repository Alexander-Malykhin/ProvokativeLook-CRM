<?php

namespace ProvokativeLook\Application\Deal\Service;

use ProvokativeLook\Application\Common\Contracts\IdHandlerInterface;
use ProvokativeLook\Application\Deal\Stage\Contracts\StageHandlerRegistryInterface;
use ProvokativeLook\Infrastructure\Repository\Contracts\DealRepositoryInterface;
final class DealProductRowsUpdateService implements IdHandlerInterface
{
    public function __construct(
        private DealRepositoryInterface $dealRepository,
        private StageHandlerRegistryInterface $registry
    ) {}
    public function handle(int $dealId): void
    {
        $deal = $this->dealRepository->getItem($dealId);
        if (!$deal) return;

        $stageId = (string)$deal->getStageId();
        $handler = $this->registry->get($stageId);

        if (!$handler) return;

        $handler->handle($deal);
    }
}