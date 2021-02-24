<?php


namespace Cleeng\Entitlements\Application\Resources;


use Cleeng\Entitlements\Domain\ResourcesAccessStrategy;
use DateTime;

class MultiLayerStrategyResources implements ResourcesAccessStrategy
{
    private Resources $resources;

    public function __construct(Resources $graphResource)
    {
        $this->resources = $graphResource;
    }

    public function haveAccessToResource($resourceId, DateTime $atTime, array $entitlements): bool
    {
        return $this->resources->isResourceAvailable($resourceId, $entitlements);
    }
}