<?php

namespace ProvokativeLook\Infrastructure\Repository\Contracts;

interface ProductRepositoryInterface
{
    public function fetchForDeal(int $dealId, array $select = ['PRODUCT_NAME', 'QUANTITY']): array;
}