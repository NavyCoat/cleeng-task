<?php


namespace Cleeng\Entitlements\Domain;


use DateTime;

class Viewer
{
    /**
     * @var Entitlement[]
     */
    private array $entitlements;
    private int $id;

    /**
     * Viewer constructor.
     * @param int $id
     * @param Entitlement[] $entitlements
     */
    public function __construct(int $id, array $entitlements = [])
    {
        $this->id = $id;
        $this->entitlements = $entitlements;
    }

    public function haveAccessToResource(
        int $resourceId,
        DateTime $atTime,
        ?ResourcesAccessStrategy $accessStrategy = null
    ): bool {
        if (!$accessStrategy) {
            return $this->entitlementIsValid($resourceId, $atTime);
        }

        return $accessStrategy->haveAccessToResource($resourceId, $atTime, $this->getValidEntitlements($atTime));
    }

    public function addEntitlement(int $resourceId, ?DateTime $expiresAt = null): void
    {
        $this->entitlements[$resourceId] = new Entitlement($resourceId, $expiresAt);
    }

    private function getValidEntitlements(DateTime $atTime): array
    {
        return array_filter(
            $this->entitlements,
            function ($entitlement) use ($atTime) {
                return $entitlement->isValid($atTime);
            }
        );
    }

    private function entitlementIsValid(int $resourceId, DateTime $atTime): bool
    {
        if ($this->isResourceInEntitlements($resourceId)) {
            return $this->entitlements[$resourceId]->isValid($atTime);
        }

        return false;
    }

    private function isResourceInEntitlements(int $resourceId): bool
    {
        return array_key_exists($resourceId, $this->entitlements);
    }
}