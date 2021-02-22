<?php

namespace Cleeng\Entitlements\Application\Repository;

use Cleeng\Entitlements\Application\Model\Resource;

interface ResourcesRepository
{
    public function getById(int $id): Resource;

    /**
     * @return Resource[]
     */
    public function getAll(): array;
}