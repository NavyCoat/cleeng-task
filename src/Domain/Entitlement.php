<?php


namespace Cleeng\Entitlements\Domain;


use DateTime;

class Entitlement
{
    private int $resourceId;
    private ?DateTime $expiresAt;

    public function __construct(int $resourceId, ?DateTime $expiresAt = null)
    {
        $this->resourceId = $resourceId;
        $this->expiresAt = $expiresAt;
    }

    public function isValid(DateTime $atTime): bool
    {
        return $this->expiresAt ? $this->expiresAt > $atTime : true;
    }

    /**
     * @return int
     */
    public function getResourceId(): int
    {
        return $this->resourceId;
    }
}