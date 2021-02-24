<?php


namespace Cleeng\Entitlements\Infrastructure;


use Cleeng\Entitlements\Application\Model\Resource;
use Cleeng\Entitlements\Application\Repository\ResourcesRepository;
use Cleeng\Entitlements\Application\Resources\Resources;
use Cleeng\Entitlements\Domain\Entitlement;

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

    /**
     * @param int $resourceId
     * @param Entitlement[] $entitlements
     * @return bool
     */
    public function isResourceAvailable(int $resourceId, array $entitlements): bool
    {
        return $this->foo($entitlements, $resourceId);
    }

    /**
     * @param Entitlement[] $entitlements
     * @param int $resourceId
     * @return bool
     */
    private function foo(array $entitlements, int $resourceId): bool
    {
        $resourceIds = [];
        foreach ($entitlements as $entitlement) {
            $resourceIds[] = $entitlement->getResourceId();
        }

        return $this->isResourceReachableUsingEntitlementResourceId($resourceIds, $resourceId);
    }

    /**
     * @param array $resourceIds
     * @param int $resourceId
     * @return bool
     */
    private function isResourceReachableUsingEntitlementResourceId(array $resourceIds, int $resourceId): bool
    {
        foreach ($resourceIds as $relatedResourceId) {
            if ($this->doesResourceExist($relatedResourceId)) {
                continue;
            }

            if ($resourceId === $relatedResourceId) {
                return true;
            }

            $relatedResources = $this->array[$relatedResourceId];
            if ($relatedResources) {
                foreach ($relatedResources as $relatedResourceID) {
                    if ($resourceId === $relatedResourceID) {
                        return true;
                    }

                    if ($this->isResourceReachableUsingEntitlementResourceId($relatedResources, $resourceId)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    //PoC było wygodniej wykorzystać to inmemory do view modelu
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

    private function doesResourceExist(int $resourceId): bool
    {
        return !array_key_exists($resourceId, $this->array);
    }

    /**
     * @param int $resourceId
     * @param Entitlement $entitlement
     * @return bool
     */
    private function isResourceAnEntitlement(int $resourceId, Entitlement $entitlement): bool
    {
        return $resourceId === $entitlement->getResourceId();
    }
}