<?php

namespace ProvokativeLook\Infrastructure\Adapter;

use Bitrix\Crm\Item;
use ProvokativeLook\Domain\Entity\Contracts\CrmItemInterface;

class DealItem implements CrmItemInterface
{
    private Item\Deal $deal;

    public function __construct(Item\Deal $deal)
    {
        $this->deal = $deal;
    }

    public function __call(string $method, array $args)
    {
        return $this->deal->$method(...$args);
    }

    public function inner(): object
    {
        return $this->deal;
    }

    public function get(string $field): mixed
    {
        return $this->deal->get($field);
    }

    public function set(string $field, $value): void
    {
        $this->deal->set($field, $value);
    }
}