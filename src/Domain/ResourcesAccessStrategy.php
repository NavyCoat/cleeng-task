<?php


namespace Cleeng\Entitlements\Domain;


use DateTime;

interface ResourcesAccessStrategy
{
    public function haveAccessToResource($resourceId, DateTime $atTime, array $entitlements): bool;
}