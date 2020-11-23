<?php

namespace AwemaPL\Subscription\Sections\Memberships\Repositories;

use AwemaPL\Subscription\Sections\Memberships\Models\Membership;
use AwemaPL\Subscription\Sections\Memberships\Repositories\Contracts\MembershipRepository;
use AwemaPL\Subscription\Sections\Memberships\Scopes\EloquentMembershipScopes;
use AwemaPL\Repository\Eloquent\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EloquentMembershipRepository extends BaseRepository implements MembershipRepository
{
    protected $searchable = [

    ];

    public function entity()
    {
        return Membership::class;
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new EloquentMembershipScopes($request))->scope($this->entity);

        return $this;
    }

    /**
     * Create new role
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        return Membership::create($data);
    }

    /**
     * Update membership
     *
     * @param array $data
     * @param int $id
     * @param string $attribute
     *
     * @return int
     */
    public function update(array $data, $id, $attribute = 'id')
    {
        return parent::update($data, $id, $attribute);
    }

    /**
     * Delete membership
     *
     * @param int $id
     */
    public function delete($id){
        $this->destroy($id);
    }

}
