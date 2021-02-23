<?php

namespace Cleeng\Entitlements\Representation\Rest;

use Cleeng\Entitlements\Application\Repository\ViewerRepository;
use Cleeng\Entitlements\Application\UseCase\CheckViewerHaveAccessToResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ViewersController
{
    private ViewerRepository $viewers;
    private CheckViewerHaveAccessToResource $checkViewerHaveAccessToResource;

    public function getViewers(Request $request): Response
    {
        $response = new JsonResponse(
            [
                'resources' => $this->viewers->getAll(),
                'actions' => [
                    'View viewer entitlements' => [
                        'method' => 'GET',
                        'href' => '/viewers/{id}/entitlements',
                        'desc' => 'Lorem ipsum dolor sit',
                    ],
                    'Upsert entitlement for Viewer' => [
                        'method' => 'PUT',
                        'href' => '/viewers/{id}/entitlements/{resource-id}',
                        'desc' => 'Lorem ipsum dolor sit',
                    ],
                    'Check is Resource available for Viewer' => [
                        'method' => 'GET',
                        'href' => '/viewers/{id}/available-resource/{resource-id}',
                        'desc' => 'Lorem ipsum dolor sit',
                    ],
                ],
            ]
        );

        $response->setCache([]);

        return $response;
    }

    /**
     * /viewers/{id}/available-resources/{id}
     * @return Response
     */
    public function getAvailableResource(Request $request): Response
    {
        //some data from Request...
        $viewerId = 1;
        $resourceId = 100;

        $result = $this->checkViewerHaveAccessToResource->run($viewerId, $resourceId);

        if (!$result) {
            return new Response(null, Response::HTTP_FORBIDDEN);
        }
        return new Response(null, Response::HTTP_NO_CONTENT);
    }


}