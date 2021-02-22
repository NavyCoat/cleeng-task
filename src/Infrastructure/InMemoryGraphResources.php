<?php


namespace Cleeng\Entitlements\Infrastructure;


use Cleeng\Entitlements\Application\Model\Resource;
use Cleeng\Entitlements\Application\Repository\ResourcesRepository;
use Cleeng\Entitlements\Application\Resources\Resources;

class InMemoryGraphResources implements Resources, ResourcesRepository
{
    private array $array;

    public function __construct(array $array = [])
    {
        $this->array = $array;
    }

    /**
     * TODO: Should I pass id?
     * I can imagine that Resources are managed in other module (CRUD)
     * In this case, I rather care about the access relationship itself.
     * I think that giving availability to make 1:1 id of resource in this module and in "catalog" is ok.
     */
    public function addResource(int $id, array $children = [], array $parents = []): void
    {
        //todo: If resource already exist

        foreach ($parents as $parent) {
            $this->array[$parent][] = $id;
        }
        $this->array[$id] = $children;
    }

    public function doesResourceExists(int $resourceId): bool
    {
        return array_key_exists($resourceId, $this->array);
    }

    public function isResourceAvailable(int $resourceId, array $entitlements): bool
    {
        if ($this->isResourceAnEntitlement($resourceId, $entitlements)) {
            return true;
        }

        return $this->findInResources($entitlements, $resourceId);
    }

    private function isResourceAnEntitlement(int $resourceId, array $entitlementIds): bool
    {
        return in_array($resourceId, $entitlementIds, true);
    }

    private function findInResources(array $entitlementIds, int $resourceId): bool
    {
        foreach ($entitlementIds as $entitlementId) {
            if (!array_key_exists($entitlementId, $this->array)) {
                continue;
            }

            $relatedResources = $this->array[$entitlementId];
            if ($relatedResources) {
                foreach ($relatedResources as $relatedResourceID) {
                    if ($resourceId === $relatedResourceID) {
                        return true;
                    }

                    if ($this->findInResources($relatedResources, $resourceId)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    //PoC było wygodniej tutaj inmemory
    public function getById(int $id): Resource
    {
        $parents = [];

        foreach ($this->array as $parentId => $children) {
            if (in_array($id, $children)) {
                $parents[] = $parentId;
            }
        }

        return new Resource($id, $this->array[$id], $parents);
    }

    public function getAll(): array
    {
        $resources = [];

        foreach ($this->array as $resourceId => $children) {
            $resources[] = $this->getById($resourceId);
        }

        return $resources;
    }
}