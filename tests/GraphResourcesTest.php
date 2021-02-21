<?php


namespace Tests;

use Cleeng\Entitlements\GraphResources;
use PHPUnit\Framework\TestCase;

class GraphResourcesTest extends TestCase
{
    /**
     * @dataProvider resourceProvider
     */
    public function testResourcesAreCorrectlyRelated(
        GraphResources $resources,
        array $entitlements,
        array $shouldHaveAccessTo,
        array $shouldNotHaveAccessTo
    ) {
        foreach ($shouldHaveAccessTo as $resourceId) {
            self::assertTrue(
                $resources->isResourceAvailableToReach($resourceId, $entitlements),
                sprintf('Failed to assert that resource "%s" is related to entitlements provided in test.', $resourceId)
            );
        }

        foreach ($shouldNotHaveAccessTo as $resourceId) {
            self::assertFalse(
                $resources->isResourceAvailableToReach($resourceId, $entitlements),
                sprintf(
                    'Failed to assert that resource "%s" is not related to entitlements provided in test.',
                    $resourceId
                )
            );
        }
    }

    public function resourceProvider(): array
    {
        return [
            [
                'resources' => new GraphResources([1 => [2, 3, 4], 2 => [5, 6], 5 => [7, 8]]),
                'entitlements' => [2],
                'shouldHaveAccessTo' => [2, 5, 6, 7, 8],
                'shouldNotHaveAccessTo' => [3, 4],
            ],
            [
                'resources' => $this->createResourceUsingAddResource(),
                'entitlements' => [2, 5],
                'shouldHaveAccessTo' => [2, 5, 6, 7, 8],
                'shouldNotHaveAccessTo' => [3, 4],
            ],
        ];
    }

    private function createResourceUsingAddResource()
    {
        $resource = new GraphResources();
        $resource->addResource(1, [2, 3, 4]);
        $resource->addResource(5, [7, 8], [2]);
        $resource->addResource(6, [], [2]);

        return $resource;
    }

}