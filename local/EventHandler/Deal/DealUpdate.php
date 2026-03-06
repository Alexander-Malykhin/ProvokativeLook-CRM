<?php

namespace ProvokativeLook\EventHandler\Deal;

use ProvokativeLook\Application\Deal\Service\DealUpdateService;
use ProvokativeLook\Application\Common\Contracts\IdHandlerInterface;
use ProvokativeLook\Application\Deal\Stage\Preparation\CreateInvoicesHandler;
use ProvokativeLook\Application\Deal\Stage\StageHandlerRegistry;
use ProvokativeLook\EventHandler\Deal\Contracts\DealUpdateInterface;
use ProvokativeLook\Infrastructure\Repository\DealRepository;
use ProvokativeLook\Infrastructure\Repository\SmartInvoiceRepository;
use ProvokativeLook\Infrastructure\Crm\Products\ProductRowFactory;

final class DealUpdate implements DealUpdateInterface
{
    /** @var callable|null */
    public static $factory = null;

    public static function onAfterUpdate(array &$arFields): void
    {
        $dealId = (int)($arFields['ID'] ?? 0);
        if ($dealId <= 0) return;

        $factory = self::$factory ?? static function (): IdHandlerInterface {
            $dealRepository = new DealRepository();
            $invoiceRepository = new SmartInvoiceRepository();
            $productRowFactory = new ProductRowFactory();

            $registry = new StageHandlerRegistry([
                new CreateInvoicesHandler($invoiceRepository, $productRowFactory),
            ]);

            return new DealUpdateService($dealRepository, $registry);
        };

        /** @var IdHandlerInterface $service */
        $service = $factory();
        $service->handle($dealId);
    }
}