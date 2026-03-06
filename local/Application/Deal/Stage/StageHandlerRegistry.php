<?php

namespace ProvokativeLook\Application\Deal\Stage;

use ProvokativeLook\Application\Deal\Stage\Contracts\StageHandlerInterface;
use ProvokativeLook\Application\Deal\Stage\Contracts\StageHandlerRegistryInterface;
final class StageHandlerRegistry implements StageHandlerRegistryInterface
{
    private array $handlers = [];
    public function __construct(iterable $handlers)
    {
        foreach ($handlers as $handler)
            $this->handlers[$handler->stageId()] = $handler;
    }
    public function get(string $stageId): ?StageHandlerInterface
    {
        return $this->handlers[$stageId] ?? null;
    }
}