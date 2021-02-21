<?php


namespace Cleeng\Entitlements;


class NoAccessStrategy implements AccessStrategy
{
    public function haveAccessToResource($resourceId, array $entitlements): bool
    {
        return false;
    }
}