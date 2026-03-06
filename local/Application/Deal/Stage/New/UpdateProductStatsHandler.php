<?php

namespace ProvokativeLook\Application\Deal\Stage\New;

use Bitrix\Crm\Automation\Starter;
use CCrmOwnerType;
use ProvokativeLook\Application\Deal\Stage\Contracts\StageHandlerInterface;
use ProvokativeLook\Infrastructure\Repository\Contracts\ProductRepositoryInterface;

use ProvokativeLook\Domain\Entity\Deal;

final class UpdateProductStatsHandler implements StageHandlerInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {}

    public function stageId(): string
    {
        return 'NEW';
    }

    public function handle(Deal $deal): void
    {
        $dealId = (int)$deal->getId();

        $rows = $this->productRepository->fetchForDeal($dealId);
        if (!$rows) return;

        $totalQuantity = 0.0;
        $productNames = [];

        foreach ($rows as $row) {
            $totalQuantity += (float)($row['QUANTITY'] ?? 0);
            $name = (string)($row['PRODUCT_NAME'] ?? '');
            if ($name !== '') $productNames[] = $name;
        }

        $fields = [
            'TOTAL_QUANTITY' => $totalQuantity,
            'PRODUCT_COUNT'  => count($rows),
            'PRODUCT_LIST'   => implode("\n", $productNames),
        ];

        $changed = false;
        foreach ($fields as $key => $value) {
            if ($deal->get($key) !== $value) {
                $deal->set($key, $value);
                $changed = true;
            }
        }
        if (!$changed) return;

        // надёжнее так, чем $deal->save()
        $saveResult = $deal->inner()->save();
        if (!$saveResult->isSuccess()) return;

        // запустить роботов текущей стадии
        $stageId = (string)$deal->getStageId();
        $starter = new Starter(CCrmOwnerType::Deal, $dealId);
        $starter->setContextToBizproc();
        $starter->runOnUpdate(['STAGE_ID' => $stageId], []);
    }
}