<?php


namespace Tests;


use Cleeng\Entitlements\Infrastructure\InMemoryGraphResources;
use Cleeng\Entitlements\Representation\Rest\ResourcesController;
use PHPUnit\Framework\TestCase;

class ResourcesControllerTest extends TestCase
{

    public function testGetResources()
    {
        $resources = new InMemoryGraphResources();
        $resources->addResource(1);
        $resources->addResource(2, [3]);
        $resources->addResource(3);

        $controller = new ResourcesController($resources);

        echo $controller->getResources()->getContent();
    }

}