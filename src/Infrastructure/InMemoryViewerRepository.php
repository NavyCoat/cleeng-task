<?php


namespace Cleeng\Entitlements\Infrastructure;


use Cleeng\Entitlements\Domain\Viewer\Viewer;
use Cleeng\Entitlements\Domain\Viewer\ViewerRepository;
use ReflectionObject;

class InMemoryViewerRepository implements ViewerRepository
{
    private $viewers = [];

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
}