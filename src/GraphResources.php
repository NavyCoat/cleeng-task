<?php


namespace Cleeng\Entitlements;


class GraphResources
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
    public function addResource($id, array $children = [], array $parents = [])
    {
        foreach ($parents as $parent) {
            $this->array[$parent][] = $id;
        }
        $this->array[$id] = $children;
    }

    public function isResourceAvailableToReach($resourceId, array $entitlements): bool
    {
        if ($this->isResourceInEntitlements($resourceId, $entitlements)) {
            return true;
        }

        return $this->findInResources($entitlements, $resourceId);
    }

    private function findInResources(array $entitlements, $resourceId): bool
    {
        foreach ($entitlements as $entitlement) {
            if (!array_key_exists($entitlement, $this->array)) {
                continue;
            }

            $relatedResources = $this->array[$entitlement];
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

    /**
     * @param $resourceId
     * @param array $entitlements
     * @return bool
     */
    private function isResourceInEntitlements($resourceId, array $entitlements): bool
    {
        return in_array($resourceId, $entitlements, true);
    }

}