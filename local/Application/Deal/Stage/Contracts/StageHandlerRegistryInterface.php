<?php

namespace ProvokativeLook\Application\Deal\Stage\Contracts;

interface StageHandlerRegistryInterface
{
    public function get(string $stageId): ?StageHandlerInterface;
}