<?php


namespace Cleeng\Entitlements\Viewer;


class Viewer
{
    private array $entitlementIds;
    private int $id;

    /**
     * Viewer constructor.
     * @param int $id
     * @param array<int> $entitlementIds
     */
    public function __construct(int $id, array $entitlementIds = [])
    {
        $this->id = $id;
        $this->entitlementIds = $entitlementIds;
    }

    public function haveAccessToResource($resourceId, ?ResourcesAccessStrategy $accessStrategy = null): bool
    {
        if (!$accessStrategy) {
            return $this->isResourceInEntitlements($resourceId);
        }

        return $accessStrategy->haveAccessToResource($resourceId, $this->entitlementIds);
    }

    private function isResourceInEntitlements($resourceId): bool
    {
        return in_array($resourceId, $this->entitlementIds, true);
    }

    public function addEntitlement(int $resourceId): void
    {
        //For simplication, i know that they can be doubled, but I think that refactor will be needed when i add expireAt.
        $this->entitlementIds[] = $resourceId;
    }
}