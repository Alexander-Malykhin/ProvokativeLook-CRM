<?php

namespace ProvokativeLook\Domain\Field;
final class DealFields
{
    // Получено товаров (число)
    public const TOTAL_QUANTITY = 'TOTAL_QUANTITY';

    // Всего товаров в сделке (число)
    public const PRODUCT_COUNT = 'PRODUCT_COUNT';

    // Список товаров (строка)
    public const PRODUCT_LIST = 'PRODUCT_LIST';

    // Тип платежа (список)
    public const TYPE_PAY = 'TYPE_PAY';

    public static function all(): array
    {
        return [
            self::TOTAL_QUANTITY,
            self::PRODUCT_COUNT,
            self::PRODUCT_LIST,
            self::TYPE_PAY,
        ];
    }
}