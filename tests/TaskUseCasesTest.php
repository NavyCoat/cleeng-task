<?php


namespace Tests;

use Cleeng\Entitlements\Application\Resources\MultiLayerStrategyResources;
use Cleeng\Entitlements\Domain\Viewer;
use Cleeng\Entitlements\Infrastructure\InMemoryGraphResources;
use PHPUnit\Framework\TestCase;

class TaskUseCasesTest extends TestCase
{
    public function testSingleEventTest()
    {
        $resourceId = 1;
        $otherResource = 123;
        $viewer = new Viewer(1);

        $viewer->addEntitlement($resourceId);

        $this->assertTrue($viewer->haveAccessToResource($resourceId, new \DateTime()));
        $this->assertFalse($viewer->haveAccessToResource($otherResource, new \DateTime()));
    }

    public function testSesonPassTest()
    {
        $resources = new InMemoryGraphResources(
            [
                1 => [2, 3], //SeasonPass and PPV events
            ]
        );
        $strategy = new MultiLayerStrategyResources($resources);
        $viewer = new Viewer(1);

        $expireDate = new \DateTime('2030-02-02');
        $dateBeforeExpire = new \DateTime('2009-02-01');
        $dateAfterExpire = new \DateTime('2040-02-01');

        $viewer->addEntitlement(1, $expireDate);

        $this->assertTrue($viewer->haveAccessToResource(2, $dateBeforeExpire, $strategy));
        $this->assertFalse($viewer->haveAccessToResource(2, $dateAfterExpire, $strategy));
    }

    public function testSilverPackageCase()
    {
        $resources = new InMemoryGraphResources(
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

        $this->assertTrue($viewer->haveAccessToResource(5, new \DateTime(), $strategy));
        $this->assertTrue($viewer->haveAccessToResource(6, new \DateTime(), $strategy));
        $this->assertFalse($viewer->haveAccessToResource(7, new \DateTime(), $strategy));
    }

    public function testGoldPackageCase()
    {
        $resources = new InMemoryGraphResources(
            [
                1 => [2, 3], //Represents Author with id 1 and his videos [2,3]
            ]
        );
        $strategy = new MultiLayerStrategyResources($resources);

        $viewer = new Viewer(1);
        $viewer->addEntitlement(1);

        $this->assertTrue($viewer->haveAccessToResource(2, new \DateTime(), $strategy));
        $this->assertTrue($viewer->haveAccessToResource(3, new \DateTime(), $strategy));
    }

}