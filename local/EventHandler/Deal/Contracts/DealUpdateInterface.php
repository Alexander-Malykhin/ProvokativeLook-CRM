<?php

namespace ProvokativeLook\EventHandler\Deal\Contracts;

interface DealUpdateInterface
{
    public static function onAfterUpdate(array &$arFields): void;
}