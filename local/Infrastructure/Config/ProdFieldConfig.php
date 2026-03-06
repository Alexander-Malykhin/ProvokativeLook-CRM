<?php

namespace ProvokativeLook\Infrastructure\Config;

use ProvokativeLook\Infrastructure\Config\Contracts\FieldConfigInterface;
final class ProdFieldConfig implements FieldConfigInterface
{
    public function deal(): array
    {
        return [
            'TOTAL_QUANTITY' => 'UF_CRM_1772091570',
            'PRODUCT_COUNT' => 'UF_CRM_1772091545',
            'PRODUCT_LIST' => 'UF_CRM_1772091597',
            'TYPE_PAY' => 'UF_CRM_1772005423370',
        ];
    }
}