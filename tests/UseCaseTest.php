<?php


namespace Tests;

use Cleeng\Entitlements\Viewer\Viewer;
use Cleeng\Entitlements\Resources\GraphResources;
use Cleeng\Entitlements\Resources\MultiLayerStrategyResources;
use PHPUnit\Framework\TestCase;

class UseCaseTest extends TestCase
{
    public function testSingleEventTest()
    {
        $resourceId = 1;
        $otherResource = 123;
        $viewer = new Viewer(1);

        $viewer->addEntitlement($resourceId);

        $this->assertTrue($viewer->haveAccessToResource($resourceId));
        $this->assertFalse($viewer->haveAccessToResource($otherResource));
    }

    public function testSesonPassTest()
    {
        $this->markTestSkipped('Todo');
    }

    public function testSilverPackageCase()
    {
        $resources = new GraphResources(
            [
                1 => [2, 3], //Silver Package with two categories id:2 id:3
                2 => [5], //Category available in Silver Package
                3 => [6], //Category available in Silver Package
                4 => [7] //Category not available in Silver Package
            ]
        );
        $strategy = new MultiLayerStrategyResources($resources);

        $viewer = new Viewer(1);
        $viewer->addEntitlement(1);

        $this->assertTrue($viewer->haveAccessToResource(5, $strategy));
        $this->assertTrue($viewer->haveAccessToResource(6, $strategy));
        $this->assertFalse($viewer->haveAccessToResource(7, $strategy));
    }

    public function testGoldPackageCase()
    {
        $resources = new GraphResources(
            [
                1 => [2,3], //Represents Author with id 1 and his videos [2,3]
            ]
        );
        $strategy = new MultiLayerStrategyResources($resources);

        $viewer = new Viewer(1);
        $viewer->addEntitlement(1);

        $this->assertTrue($viewer->haveAccessToResource(2, $strategy));
        $this->assertTrue($viewer->haveAccessToResource(3, $strategy));
    }

}