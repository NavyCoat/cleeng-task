<?php


namespace Cleeng\Entitlements;


interface AccessStrategy
{
    public function haveAccessToResource($resourceId, array $entitlements): bool;
}