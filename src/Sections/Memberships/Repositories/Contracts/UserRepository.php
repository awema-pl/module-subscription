<?php

namespace AwemaPL\Subscription\Sections\Memberships\Repositories\Contracts;

use Illuminate\Http\Request;

interface UserRepository
{
    /**
     * Scope membership
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function scope($request);
}
