<?php

namespace AwemaPL\Subscription\Facades;

use AwemaPL\Subscription\Contracts\Subscription as SubscriptionContract;
use Illuminate\Support\Facades\Facade;

class Subscription extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SubscriptionContract::class;
    }
}
