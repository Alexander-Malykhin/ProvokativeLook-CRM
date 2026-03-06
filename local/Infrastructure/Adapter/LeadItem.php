<?php

namespace ProvokativeLook\Infrastructure\Adapter;

use Bitrix\Crm\Item;
use ProvokativeLook\Domain\Entity\Contracts\CrmItemInterface;

class LeadItem implements CrmItemInterface
{
    private Item\Lead $lead;

    public function __construct(Item\Lead $lead)
    {
        $this->lead = $lead;
    }

    public function __call(string $method, array $args)
    {
        return $this->lead->$method(...$args);
    }

    public function inner(): object
    {
        return $this->lead;
    }

    public function get(string $field): mixed
    {
        return $this->lead->get($field);
    }

    public function set(string $field, $value): void
    {
        $this->lead->lead($field, $value);
    }
}