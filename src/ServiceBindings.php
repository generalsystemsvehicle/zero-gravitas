<?php

namespace GeneralSystemsVehicle\Acclaim;

trait ServiceBindings
{
    /**
     * All of the service bindings for package.
     *
     * @var array
     */
    protected $serviceBindings = [
        Api\AuthorizationTokens::class,
        Api\Badges::class,
        Api\BadgeTemplates::class,
        Api\Events::class,
        Api\Grantors::class,
        Api\Issuers::class,
        Api\Obi::class,
        Api\Organizations::class,
    ];
}
