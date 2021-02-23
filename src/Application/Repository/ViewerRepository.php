<?php


namespace Cleeng\Entitlements\Application\Repository;


use Cleeng\Entitlements\Domain\Viewer\Viewer;

interface ViewerRepository
{
    /**
     * @return Viewer[]
     */
    public function getAll(): array;
}