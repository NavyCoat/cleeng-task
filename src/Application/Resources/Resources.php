<?php

namespace Cleeng\Entitlements\Application\Resources;

interface Resources
{
    /**
     * TODO: Should I pass id?
     * I can imagine that Resources are managed in other module (CRUD)
     * In this case, I rather care about the access relationship itself.
     * I think that giving availability to make 1:1 id of resource in this module and in "catalog" is ok.
     */
    public function addResource(int $id, array $children = [], array $parents = []): void;

    public function isResourceAvailable(int $resourceId, array $entitlements): bool;

    public function doesResourceExists(int $resourceId): bool;
}