<?php

namespace Cleeng\Entitlements\Representation\Rest;

use Cleeng\Entitlements\Application\Repository\ResourcesRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ResourcesController
{
    private ResourcesRepository $resources;

    public function __construct(ResourcesRepository $resources)
    {
        $this->resources = $resources;
    }

    public function getResources(): Response
    {
        $response = new JsonResponse(
            [
                'resources' => $this->resources->getAll(),
                'actions' => [
                    'View specific resource' => [
                        'method' => 'GET',
                        'href' => '/resources/{id}',
                        'desc' => 'Lorem ipsum dolor sit',
                    ],
                    'Upsert resource' => [
                        'method' => 'PUT',
                        'href' => '/resources/{id}',
                        'desc' => 'Lorem ipsum dolor sit',
                    ],
                ],
            ]
        );

        $response->setCache([]);

        return $response;
    }

    public function getResource(Request $request): Response
    {
        $id = 100;

        $response = new JsonResponse(
            [
                $this->resources->getById($id),
                'actions' => [
                    'Upsert Resource' => [
                        'method' => 'PUT',
                        'href' => '/resources/{id}',
                    ],
                    'Entitle Viewer to Resource' => [
                        'method' => 'PUT',
                        'href' => '/resources/{id}',
                    ],
                    'Check Viewer can access Resource' => [
                        'method' => 'GET',
                        'href' => '/viewers/{viewer-id}/available-resources/{resource-id}',
                    ],
                ],
            ]
        );

        $response->setCache([]);

        return $response;
    }
}