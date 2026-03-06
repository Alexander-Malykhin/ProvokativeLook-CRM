<?php

namespace ProvokativeLook\Domain\Entity\Contracts;

interface CrmItemInterface
{

    public function inner(): object;

    public function get(string $field): mixed;

    public function set(string $field, $value): void;
}