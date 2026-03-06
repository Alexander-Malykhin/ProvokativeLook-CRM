<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Bitrix\Main\EventManager;
use Bitrix\Main\Loader;

use ProvokativeLook\EventHandler\Deal\DealUpdate;
use ProvokativeLook\EventHandler\Deal\DealProductRowsSave;

Loader::includeModule('crm');

//on After Deal Update
EventManager::getInstance()->addEventHandler(
    'crm',
    'OnAfterCrmDealUpdate',
    [DealUpdate::class, 'onAfterUpdate']
);

//on After Deal Product Save
EventManager::getInstance()->addEventHandler(
    'crm',
    'OnAfterCrmDealProductRowsSave',
    [DealProductRowsSave::class, 'onAfterSave']
);