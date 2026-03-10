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

    // Собран на складе (да/нет)
    public const ASSEMBLED = 'ASSEMBLED';

    // Упакован (да/нет)
    public const PACKED = 'PACKED';

    // Отправлен (да/нет)
    public const SHIPPED = 'SHIPPED';

    // Доставлен (да/нет)
    public const DELIVERED = 'DELIVERED';

    public static function all(): array
    {
        return [
            self::TOTAL_QUANTITY,
            self::PRODUCT_COUNT,
            self::PRODUCT_LIST,
            self::TYPE_PAY,
            self::ASSEMBLED,
            self::PACKED,
            self::SHIPPED,
            self::DELIVERED,
        ];
    }
}