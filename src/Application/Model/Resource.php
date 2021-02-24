<?php

namespace Cleeng\Entitlements\Application\Model;

use JsonSerializable;

class Resource implements JsonSerializable
{
    private int $id;
    private array $children;
    private array $parents;

    public function __construct(int $id, array $children, array $parents)
    {
        $this->id = $id;
        $this->children = $children;
        $this->parents = $parents;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return array<int>
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @return array<int>
     */
    public function getParents(): array
    {
        return $this->parents;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'children' => $this->getChildren(),
            'parents' => $this->getParents(),
        ];
    }


}