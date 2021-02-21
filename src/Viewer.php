<?php


namespace Cleeng\Entitlements;


class Viewer
{
    private array $entitlements;
    private int $id;

    /**
     * Viewer constructor.
     * @param int $id
     * @param array<int> $entitlements
     */
    public function __construct(int $id, array $entitlements = [])
    {
        $this->id = $id;
        $this->entitlements = $entitlements;
    }

    public function haveAccessToResource($resourceId, ?AccessStrategy $accessStrategy = null): bool
    {
        if (!$accessStrategy) {
            return $this->isResourceInEntitlements($resourceId);
        }

        return $accessStrategy->haveAccessToResource($resourceId, $this->entitlements);
    }

    public function addEntitlement(int $resourceId):void
    {
        //For simplication, i know that they can be doubled, but I think that refactor will be needed when i add expireAt.
        $this->entitlements[] = $resourceId;
    }

    private function isResourceInEntitlements($resourceId): bool
    {
        return in_array($resourceId, $this->entitlements, true);
    }
}