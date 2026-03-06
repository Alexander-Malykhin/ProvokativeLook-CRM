<?php

namespace ProvokativeLook\Infrastructure\Config\Factory;

use ProvokativeLook\Infrastructure\Config\Contracts\FieldConfigInterface;

use ProvokativeLook\Infrastructure\Config\DevFieldConfig;
use ProvokativeLook\Infrastructure\Config\ProdFieldConfig;

final class FieldConfigFactory
{
    public static function create(): FieldConfigInterface
    {
        $env = defined('APP_ENV') ? APP_ENV : 'prod';

        return match ($env) {
            'dev' => new DevFieldConfig(),
            'prod' => new ProdFieldConfig(),
            default => new ProdFieldConfig(),
        };
    }
}