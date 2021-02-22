<?php


namespace Cleeng\Entitlements\Application\UseCase;


use Cleeng\Entitlements\Application\Resources\MultiLayerStrategyResources;
use Cleeng\Entitlements\Application\Resources\Resources;
use Cleeng\Entitlements\Domain\Viewer\ViewerRepository;

class CheckViewerHaveAccessToResource
{
    private ViewerRepository $viewers;
    private Resources $resources;

    public function __construct(ViewerRepository $viewers, Resources $resources)
    {
        $this->viewers = $viewers;
        $this->resources = $resources;
    }

    public function __invoke(int $viewerId, int $resourceId): bool
    {
        $strategy = new MultiLayerStrategyResources($this->resources);
        $viewer = $this->viewers->findOrCreate($viewerId);

        return $viewer->haveAccessToResource($resourceId, $strategy);
    }
}