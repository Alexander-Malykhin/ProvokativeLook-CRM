<?php

namespace ProvokativeLook\Infrastructure\Field;

use ProvokativeLook\Infrastructure\Config\Factory\FieldConfigFactory;
final class FieldResolver
{
    private array $map;
    public function __construct()
    {
        $config = FieldConfigFactory::create();
        $this->map = $config->deal();
    }
    public function resolve(string $key): ?string
    {
        return $this->map[$key] ?? null;
    }
}