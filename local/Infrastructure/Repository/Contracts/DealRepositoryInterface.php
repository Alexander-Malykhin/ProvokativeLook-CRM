<?php

namespace ProvokativeLook\Infrastructure\Repository\Contracts;

use ProvokativeLook\Domain\Entity\Deal;

interface DealRepositoryInterface
{
    public function getItem(int $id): ?Deal;
}