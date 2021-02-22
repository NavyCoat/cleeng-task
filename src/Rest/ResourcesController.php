<?php

namespace Cleeng\Entitlements\Rest;

use Cleeng\Entitlements\GraphResources;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ResourcesController
{
    private GraphResources $resources;

    /**
     * /resources GET
     * /resources/{id} GET,PUT
     */
    public function getResources(): Response
    {
        //It can returns paginated view of resources

        $response = new JsonResponse(
            [
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
        //storage -> get resource representation

        $response = new JsonResponse(
            [
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

    public function putResource(Request $request): Response
    {
        $data = $request->toArray();
        $this->resources->addResource(
            $data['id'],
            $data['children'],
            $data['parents'],
        );

        $response = new JsonResponse(
            [
                'actions' => [
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
}