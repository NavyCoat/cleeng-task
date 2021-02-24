<?php


namespace Tests;

use Cleeng\Entitlements\Application\UseCase\AddEntitlementToViewer;
use Cleeng\Entitlements\Application\UseCase\AddResource;
use Cleeng\Entitlements\Application\UseCase\CheckViewerHaveAccessToResource;
use Cleeng\Entitlements\Domain\Viewer;
use Cleeng\Entitlements\Infrastructure\InMemoryGraphResources;
use Cleeng\Entitlements\Infrastructure\InMemoryViewerRepository;
use DateTime;
use PHPUnit\Framework\TestCase;

class ApplicationUseCasesTest extends TestCase
{
    public function testAddEntitlementToViewerUseCase()
    {
        //Given
        $viewers = new InMemoryViewerRepository();
        $addEntitlementToViewer = new AddEntitlementToViewer($viewers);

        //When
        $addEntitlementToViewer->run(10, 1);

        //Then
        $viewer = $viewers->findOrCreate(1);
        self::assertTrue($viewer->haveAccessToResource(10, new DateTime()));
    }

    public function testCheckViewerHaveAccessToResourceUseCase()
    {
        //Given
        $resources = new InMemoryGraphResources();
        $resources->addResource(10);

        $viewer = new Viewer(1);
        $viewer->addEntitlement(10);

        $viewers = new InMemoryViewerRepository();
        $viewers->save($viewer);

        $checkViewerHaveAccessToResource = new CheckViewerHaveAccessToResource($viewers, $resources);

        //When
        $result = $checkViewerHaveAccessToResource->run(1, 10, new DateTime());

        //Then
        self::assertTrue($result);
    }

    public function testAddResourceUseCase()
    {
        //Given
        $resources = new InMemoryGraphResources();
        $addResource = new AddResource($resources);

        //When
        $addResource->run(100);

        //Then
        self::assertNotNull($resources->getById(100));
    }

}