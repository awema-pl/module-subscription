<?php

namespace AwemaPL\Subscription\Traits;

use AwemaPL\Subscription\Sections\Memberships\Models\Membership;
use AwemaPL\Subscription\Sections\Options\Models\Option;

trait HasSubscription
{
    public function membership()
    {
        return $this->hasOne(Membership::class);
    }
}
