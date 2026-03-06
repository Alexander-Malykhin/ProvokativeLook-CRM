<?php

namespace ProvokativeLook\Infrastructure\Config;

use ProvokativeLook\Infrastructure\Config\Contracts\FieldConfigInterface;
final class DevFieldConfig implements FieldConfigInterface
{
    public function deal(): array
    {
        return [
            'TOTAL_QUANTITY' => 'UF_CRM_1772024662',
            'PRODUCT_COUNT' => 'UF_CRM_1772024639',
            'PRODUCT_LIST' => 'UF_CRM_1772024789',
            'TYPE_PAY' => 'UF_CRM_1772366041804',
        ];
    }
}