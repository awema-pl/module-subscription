<?php

namespace AwemaPL\Subscription\Sections\Memberships\Scopes;

use AwemaPL\Repository\Scopes\ScopesAbstract;

class EloquentUserScopes extends ScopesAbstract
{
    protected $scopes = [
        'q'=>SearchUser::class,
    ];
}
