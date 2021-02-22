<?php


namespace Cleeng\Entitlements\Application\UseCase;


use Cleeng\Entitlements\Domain\Viewer\ViewerRepository;

class AddEntitlementToViewer
{
    private ViewerRepository $viewers;

    public function __construct(ViewerRepository $viewers)
    {
        $this->viewers = $viewers;
    }

    public function  __invoke(int $entitlementId, int $viewerId): void
    {
        $viewer = $this->viewers->findOrCreate($viewerId);

        $viewer->addEntitlement($entitlementId);

        $this->viewers->save($viewer);
    }
}