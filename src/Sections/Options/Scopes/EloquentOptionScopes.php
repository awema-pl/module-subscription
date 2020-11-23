<?php

namespace AwemaPL\Subscription\Sections\Options\Scopes;

use AwemaPL\Repository\Scopes\ScopesAbstract;

class EloquentOptionScopes extends ScopesAbstract
{
    protected $scopes = [
        'q' => SearchOption::class,
    ];
}
