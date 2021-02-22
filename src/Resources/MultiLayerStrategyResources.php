<?php


namespace Cleeng\Entitlements\Resources;


use Cleeng\Entitlements\Viewer\ResourcesAccessStrategy;

class MultiLayerStrategyResources implements ResourcesAccessStrategy
{
    private GraphResources $graphResource;

    public function __construct(GraphResources $graphResource)
    {
        $this->graphResource = $graphResource;
    }

    public function haveAccessToResource($resourceId, array $entitlements): bool
    {
        //Hmm I wanted to remove aspect of "Entitlements" from graphResource,
        //But I think that specific implementations can gain additional performance when providing to them
        //all data at once.
        return $this->graphResource->isResourceAvailable($resourceId, $entitlements);
    }
}