<?php

namespace ProvokativeLook\Infrastructure\Repository;

use Bitrix\Crm\ProductRowTable;

use ProvokativeLook\Infrastructure\Repository\Contracts\ProductRepositoryInterface;
final class ProductRepository implements ProductRepositoryInterface
{
    public function fetchForDeal(int $dealId, array $select = ['PRODUCT_NAME', 'QUANTITY']): array
    {
        return ProductRowTable::getList([
            'filter' => [
                '=OWNER_ID' => $dealId,
                '=OWNER_TYPE' => 'D',
            ],
            'select' => $select,
        ])->fetchAll();
    }
}