<?php


namespace Cleeng\Entitlements\Application\UseCase;


use Cleeng\Entitlements\Application\Resources\MultiLayerStrategyResources;
use Cleeng\Entitlements\Application\Resources\Resources;
use Cleeng\Entitlements\Domain\ViewerRepository;
use DateTime;

class CheckViewerHaveAccessToResource
{
    private ViewerRepository $viewers;
    private Resources $resources;

    public function __construct(ViewerRepository $viewers, Resources $resources)
    {
        $this->viewers = $viewers;
        $this->resources = $resources;
    }

    public function run(int $viewerId, int $resourceId, DateTime $atTime): bool
    {
        $strategy = new MultiLayerStrategyResources($this->resources);
        $viewer = $this->viewers->findOrCreate($viewerId);

        return $viewer->haveAccessToResource($resourceId, $atTime, $strategy);
    }
}