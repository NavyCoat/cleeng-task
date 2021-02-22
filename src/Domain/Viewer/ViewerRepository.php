<?php


namespace Cleeng\Entitlements\Domain\Viewer;


interface ViewerRepository
{
    public function findOrCreate($id): Viewer;

    public function save(Viewer $viewer): void;
}