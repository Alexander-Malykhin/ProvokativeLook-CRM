<?php

namespace ProvokativeLook\Infrastructure\Crm\Products;

use Bitrix\Crm\ProductRow;

final class ProductRowFactory
{
    public function fromDealRowWithPercent(array $srcRow, float $percent): ProductRow
    {
        $row = new ProductRow();

        $row->setProductId((int)($srcRow['PRODUCT_ID'] ?? 0));
        $row->setProductName((string)($srcRow['PRODUCT_NAME'] ?? ''));
        $row->setQuantity((float)($srcRow['QUANTITY'] ?? 0));

        $price = (float)($srcRow['PRICE'] ?? 0);
        $discountSum = (float)($srcRow['DISCOUNT_SUM'] ?? 0);

        $row->setPrice(round($price * ($percent / 100), 2));
        $row->setDiscountSum(round($discountSum * ($percent / 100), 2));

        if (array_key_exists('DISCOUNT_TYPE_ID', $srcRow)) $row->setDiscountTypeId((int)$srcRow['DISCOUNT_TYPE_ID']);
        if (array_key_exists('DISCOUNT_RATE', $srcRow)) $row->setDiscountRate((float)$srcRow['DISCOUNT_RATE']);
        if (array_key_exists('TAX_RATE', $srcRow)) $row->setTaxRate((float)$srcRow['TAX_RATE']);
        if (array_key_exists('TAX_INCLUDED', $srcRow)) $row->setTaxIncluded($srcRow['TAX_INCLUDED']);
        if (array_key_exists('CUSTOMIZED', $srcRow)) $row->setCustomized($srcRow['CUSTOMIZED']);
        if (array_key_exists('MEASURE_CODE', $srcRow)) $row->setMeasureCode((int)$srcRow['MEASURE_CODE']);
        if (array_key_exists('MEASURE_NAME', $srcRow)) $row->setMeasureName((string)$srcRow['MEASURE_NAME']);
        if (array_key_exists('SORT', $srcRow)) $row->setSort((int)$srcRow['SORT']);
        if (array_key_exists('TYPE', $srcRow)) $row->setType((int)$srcRow['TYPE']);

        return $row;
    }
}