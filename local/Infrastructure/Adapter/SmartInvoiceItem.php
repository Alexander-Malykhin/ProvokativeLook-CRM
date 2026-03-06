<?php

namespace ProvokativeLook\Infrastructure\Adapter;

use Bitrix\Crm\Item;
use ProvokativeLook\Domain\Entity\Contracts\CrmItemInterface;

final class SmartInvoiceItem implements CrmItemInterface
{
    private Item\SmartInvoice $smartInvoice;

    public function __construct(Item\SmartInvoice $smartInvoice)
    {
        $this->smartInvoice = $smartInvoice;
    }

    public function __call(string $method, array $args)
    {
        return $this->smartInvoice->$method(...$args);
    }

    public function inner(): object
    {
        return $this->smartInvoice;
    }

    public function get(string $field): mixed
    {
        return $this->smartInvoice->get($field);
    }

    public function set(string $field, mixed $value): void
    {
        $this->smartInvoice->set($field, $value);
    }
}