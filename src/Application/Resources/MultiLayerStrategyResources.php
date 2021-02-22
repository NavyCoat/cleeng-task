<?php


namespace Cleeng\Entitlements\Application\Resources;


use Cleeng\Entitlements\Domain\Viewer\ResourcesAccessStrategy;

class MultiLayerStrategyResources implements ResourcesAccessStrategy
{
    private Resources $resources;

    public function __construct(Resources $graphResource)
    {
        $this->resources = $graphResource;
    }

    public function haveAccessToResource($resourceId, array $entitlements): bool
    {
        //Hmm I wanted to remove aspect of "Entitlements" from graphResource,
        //But I think that specific implementations can gain additional performance when providing to them
        //all data at once.
        return $this->resources->isResourceAvailable($resourceId, $entitlements);
    }
}