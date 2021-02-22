<?php


namespace Cleeng\Entitlements\Domain\Viewer;


interface ResourcesAccessStrategy
{
    public function haveAccessToResource($resourceId, array $entitlements): bool;
}