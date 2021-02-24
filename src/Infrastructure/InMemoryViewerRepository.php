<?php


namespace Cleeng\Entitlements\Infrastructure;


use Cleeng\Entitlements\Application\Model\Viewer as ApplicationViewer;
use Cleeng\Entitlements\Application\Repository\ViewerRepository as ApplicationViewerRepository;
use Cleeng\Entitlements\Domain\Viewer;
use Cleeng\Entitlements\Domain\ViewerRepository;
use ReflectionObject;

class InMemoryViewerRepository implements ViewerRepository, ApplicationViewerRepository
{
    private array $viewers = [];

    public function getById($id): Viewer
    {
        return $this->viewers[$id];
    }

    public function findOrCreate($id): Viewer
    {
        if (array_key_exists($id, $this->viewers)) {
            return $this->viewers[$id];
        }

        return new Viewer($id);
    }

    public function save(Viewer $viewer): void
    {
        $id = $this->getIdForViewer($viewer);

        $this->viewers[$id] = $viewer;
    }

    /**
     * @param Viewer $viewer
     * @return mixed
     */
    private function getIdForViewer(Viewer $viewer)
    {
        $r = new ReflectionObject($viewer);
        $p = $r->getProperty('id');
        $p->setAccessible(true);

        return $p->getValue($viewer);
    }

    /////////////////////////////////////////////

    public function getAll(): array
    {
        $result = [];
        foreach ($this->viewers as $viewer) {
            $result = new ApplicationViewer($this->getIdForViewer($viewer));
        }

        return $result;
    }
}