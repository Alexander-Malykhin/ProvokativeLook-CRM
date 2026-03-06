<?php

namespace ProvokativeLook\Application\Deal\Stage\Contracts;

use ProvokativeLook\Domain\Entity\Deal;

interface StageHandlerInterface
{
    public function stageId(): string;
    public function handle(Deal $deal): void;
}