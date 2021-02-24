<?php


namespace Cleeng\Entitlements\Domain;


interface ViewerRepository
{
    public function findOrCreate($id): Viewer;

    public function save(Viewer $viewer): void;
}