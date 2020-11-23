<?php

namespace AwemaPL\Subscription\Sections\Memberships\Repositories;

use AwemaPL\Subscription\Sections\Memberships\Models\Membership;
use AwemaPL\Subscription\Sections\Memberships\Repositories\Contracts\MembershipRepository;
use AwemaPL\Subscription\Sections\Memberships\Repositories\Contracts\UserRepository;
use AwemaPL\Subscription\Sections\Memberships\Scopes\EloquentMembershipScopes;
use AwemaPL\Repository\Eloquent\BaseRepository;
use AwemaPL\Subscription\Sections\Memberships\Scopes\EloquentUserScopes;
use Illuminate\Support\Facades\Auth;

class EloquentUserRepository extends BaseRepository implements UserRepository
{
    protected $searchable = [

    ];

    public function entity()
    {
        return config('auth.providers.users.model');
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new EloquentUserScopes($request))->scope($this->entity);

        return $this;
    }
    
}
