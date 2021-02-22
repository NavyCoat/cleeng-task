<?php

namespace Cleeng\Entitlements\Representation\Rest;

interface RestController
{
    /**
     * /resources GET
     * /resources/{id} GET,PUT
     *
     * /viewers/ GET
     * /viewers/{id} GET,PUT
     *
     * /viewers/{id}/entitlements GET
     * /viewers/{id}/entitlements/{id} GET, PUT
     *
     * /viewers/{id}/available-resources/
     * /viewers/{id}/available-resources/{id} - maybe redirect to payment when resource not available?
     */
}