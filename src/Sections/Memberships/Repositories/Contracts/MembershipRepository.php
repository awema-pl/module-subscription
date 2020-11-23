<?php

namespace AwemaPL\Subscription\Sections\Memberships\Repositories\Contracts;

use AwemaPL\Subscription\Sections\Options\Http\Requests\UpdateOption;
use Illuminate\Http\Request;

interface MembershipRepository
{
    /**
     * Create membership
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data);

    /**
     * Scope membership
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function scope($request);
    
    /**
     * Update membership
     *
     * @param array $data
     * @param int $id
     *
     * @return int
     */
    public function update(array $data, $id);
    
    /**
     * Delete membership
     *
     * @param int $id
     */
    public function delete($id);

}
