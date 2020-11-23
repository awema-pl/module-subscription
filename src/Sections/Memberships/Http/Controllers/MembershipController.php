<?php

namespace AwemaPL\Subscription\Sections\Memberships\Http\Controllers;

use AwemaPL\Auth\Controllers\Traits\RedirectsTo;
use AwemaPL\Subscription\Sections\Memberships\Http\Requests\StoreMembership;
use AwemaPL\Subscription\Sections\Memberships\Http\Requests\UpdateMembership;
use AwemaPL\Subscription\Sections\Memberships\Models\Membership;
use AwemaPL\Subscription\Sections\Memberships\Repositories\Contracts\MembershipRepository;
use AwemaPL\Subscription\Sections\Memberships\Repositories\Contracts\UserRepository;
use AwemaPL\Subscription\Sections\Memberships\Resources\EloquentMembership;
use AwemaPL\Subscription\Sections\Installations\Http\Requests\StoreInstallation;
use AwemaPL\Permission\Repositories\Contracts\PermissionRepository;
use AwemaPL\Permission\Resources\EloquentPermission;
use AwemaPL\Subscription\Sections\Memberships\Resources\EloquentUser;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MembershipController extends Controller
{

    /**
     * Memberships repository instance
     *
     * @var MembershipRepository
     */
    protected $memberships;

    /** @var UserRepository $users */
    protected $users;

    public function __construct(MembershipRepository $memberships, UserRepository $users)
    {
        $this->memberships = $memberships;
        $this->users = $users;
    }

    /**
     * Display memberships
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('subscription::sections.memberships.index');
    }

    /**
     * Request scope
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function scope(Request $request)
    {
        return EloquentMembership::collection(
            $this->memberships->scope($request)
                ->latest()->smartPaginate()
        );
    }

    /**
     * Create membership
     *
     * @param StoreMembership $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(StoreMembership $request)
    {
        $this->memberships->create($request->all());
        return notify(_p('subscription::notifies.memberships.success_created_membership', 'Success created membership.'));
    }

    /**
     * Request scope users
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function scopeUsers(Request $request)
    {
        return EloquentUser::collection(
            $this->users->scope($request)
                ->latest()->smartPaginate()
        );
    }

    /**
     * Request scope options 
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function scopeOptions(Request $request)
    {
        return EloquentUser::collection(
            $this->users->scope($request)
                ->latest()->smartPaginate()
        );
    }

    /**
     * Update membership
     *
     * @param UpdateMembership $request
     * @param $id
     * @return array
     */
    public function update(UpdateMembership $request, $id)
    {
        $this->memberships->update($request->all(), $id);
        return notify(_p('subscription::notifies.memberships.success_updated_membership', 'Success updated membership.'));
    }
    
    /**
     * Delete membership
     *
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        $this->memberships->delete($id);

        return notify(_p('subscription::notifies.memberships.success_deleted_membership', 'Success deleted membership.'));
    }
}
