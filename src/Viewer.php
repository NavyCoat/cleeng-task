<?php


namespace Cleeng\Entitlements;


class Viewer
{
    private array $entitlements;
    private int $id;

    /**
     * Viewer constructor.
     * @param array<int> $entitlements
     * @param int $id
     */
    public function __construct(array $entitlements, int $id)
    {
        $this->entitlements = $entitlements;
        $this->id = $id;
    }

    public function haveAccesSToResource($resourceId): bool
    {
        return in_array($resourceId, $this->entitlements, true);
    }
}