<?php

namespace ProvokativeLook\EventHandler\Deal;

use ProvokativeLook\Application\Deal\Service\DealProductRowsUpdateService;
use ProvokativeLook\Application\Common\Contracts\IdHandlerInterface;
use ProvokativeLook\Application\Deal\Stage\New\UpdateProductStatsHandler;
use ProvokativeLook\Application\Deal\Stage\StageHandlerRegistry;
use ProvokativeLook\EventHandler\Deal\Contracts\DealProductRowsSaveInterface;
use ProvokativeLook\Infrastructure\Repository\DealRepository;
use ProvokativeLook\Infrastructure\Repository\ProductRepository;

final class DealProductRowsSave implements DealProductRowsSaveInterface
{
    /** @var callable|null */
    public static $factory = null;

    public static function onAfterSave($dealId, $rows): void
    {
        $dealId = (int)$dealId;
        if ($dealId <= 0) return;

        $factory = self::$factory ?? static function (): IdHandlerInterface {
            $registry = new StageHandlerRegistry([
                new UpdateProductStatsHandler(new ProductRepository()),
            ]);

            return new DealProductRowsUpdateService(
                new DealRepository(),
                $registry
            );
        };

        /** @var DealProductRowsUpdateService $service */
        $service = $factory();
        $service->handle($dealId);
    }
}