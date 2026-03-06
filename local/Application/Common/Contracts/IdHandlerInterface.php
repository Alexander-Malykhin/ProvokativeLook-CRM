<?php

namespace ProvokativeLook\Application\Common\Contracts;

interface IdHandlerInterface
{
    public function handle(int $id): void;
}