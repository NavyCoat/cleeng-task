<?php

namespace Cleeng\Entitlements\Application\Model;

use JsonSerializable;

class Viewer implements JsonSerializable
{
    private int $id;
    private array $entitlements;

    /**
     * @param int $id
     * @param array<int> $entitlements
     */
    public function __construct(int $id, array $entitlements)
    {
        $this->id = $id;
        $this->entitlements = $entitlements;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int[]
     */
    public function getEntitlements(): array
    {
        return $this->entitlements;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'entitlements' => $this->getEntitlements(),
        ];
    }
}