<?php


namespace Cleeng\Entitlements\Application\UseCase;


use Cleeng\Entitlements\Application\Resources\Resources;

class AddResource
{
    private Resources $resources;

    public function __construct(Resources $resources)
    {
        $this->resources = $resources;
    }

    public function  run($id, array $children = [], array $parents = []): void
    {
        $this->resources->addResource($id, $children, $parents);
    }
}