<?php


namespace Tests;

use Cleeng\Entitlements\Application\UseCase\AddEntitlementToViewer;
use Cleeng\Entitlements\Application\UseCase\AddResource;
use Cleeng\Entitlements\Application\UseCase\CheckViewerHaveAccessToResource;
use Cleeng\Entitlements\Domain\Viewer\Viewer;
use Cleeng\Entitlements\Infrastructure\InMemoryGraphResources;
use Cleeng\Entitlements\Infrastructure\InMemoryViewerRepository;
use PHPUnit\Framework\TestCase;

class ApplicationUseCasesTest extends TestCase
{
    public function testAddEntitlementToViewerUseCase()
    {
        //Given
        $viewers = new InMemoryViewerRepository();
        $addEntitlementToViewer = new AddEntitlementToViewer($viewers);

        //When
        $addEntitlementToViewer(10, 1);

        //Then
        $viewer = $viewers->findOrCreate(1);
        self::assertTrue($viewer->haveAccessToResource(10));
    }

    public function testCheckViewerHaveAccessToResourceUseCase()
    {
        //Given
        $resources = new InMemoryGraphResources([10]);
        $viewers = new InMemoryViewerRepository();
        $resources->addResource(10);
        $viewer = new Viewer(1, [10]);
        $viewer->addEntitlement(10);
        $viewers->save($viewer);
        $checkViewerHaveAccessToResource = new CheckViewerHaveAccessToResource($viewers, $resources);

        //When
        $result = $checkViewerHaveAccessToResource(1, 10);

        //Then
        self::assertTrue($result);
    }

    public function testAddResourceUseCase()
    {
        //Given
        $resources = new InMemoryGraphResources();
        $addResource = new AddResource($resources);

        //When
        $addResource(100);

        //Then
        self::assertNotNull($resources->getById(100));
    }

}