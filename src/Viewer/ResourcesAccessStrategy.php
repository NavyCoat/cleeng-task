<?php


namespace Cleeng\Entitlements\Viewer;


interface ResourcesAccessStrategy
{
    public function haveAccessToResource($resourceId, array $entitlements): bool;
}