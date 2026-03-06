<?php

namespace ProvokativeLook\EventHandler\Deal\Contracts;

interface DealProductRowsSaveInterface
{
    public static function onAfterSave($dealId, $rows): void;

}