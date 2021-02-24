<?php


namespace Cleeng\Entitlements\Application\Repository;


use Cleeng\Entitlements\Application\Model\Viewer;

interface ViewerRepository
{
    /**
     * @return Viewer[]
     */
    public function getAll(): array;
}