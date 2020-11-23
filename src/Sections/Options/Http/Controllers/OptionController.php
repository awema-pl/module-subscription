<?php

namespace AwemaPL\Subscription\Sections\Options\Http\Controllers;

use AwemaPL\Auth\Controllers\Traits\RedirectsTo;
use AwemaPL\Subscription\Sections\Options\Http\Requests\StoreCreate;
use AwemaPL\Subscription\Sections\Options\Http\Requests\StoreOption;
use AwemaPL\Subscription\Sections\Options\Http\Requests\UpdateOption;
use AwemaPL\Subscription\Sections\Options\Repositories\Contracts\OptionRepository;
use AwemaPL\Subscription\Sections\Options\Resources\EloquentOption;
use AwemaPL\Subscription\Sections\Installations\Http\Requests\StoreInstallation;
use AwemaPL\Permission\Repositories\Contracts\PermissionRepository;
use AwemaPL\Permission\Resources\EloquentPermission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Money\Money;

class OptionController extends Controller
{

    /**
     * Options repository instance
     *
     * @var OptionRepository
     */
    protected $options;

    public function __construct(OptionRepository $options)
    {
        $this->options = $options;
    }

    /**
     * Display create package form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('subscription::sections.options.index');
    }

    /**
     * Request scope
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function scope(Request $request)
    {
        return EloquentOption::collection(
            $this->options->scope($request)
                ->latest()->smartPaginate()
        );
    }

    /**
     * Create option
     *
     * @param StoreMembership $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(StoreOption $request)
    {
        $this->options->create($request->all());
        return notify(_p('subscription::notifies.options.success_created_option', 'Success created option.'));
    }

    /**
     * Update option
     *
     * @param UpdateOption $request
     * @param $id
     * @return array
     */
    public function update(UpdateOption $request, $id)
    {
        $this->options->update($request->all(), $id);

        return notify(_p('subscription::notifies.options.success_deleted_option', 'Success deleted membership.'));
    }

    /**
     * Delete option
     *
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        $this->options->delete($id);

        return notify(_p('subscription::notifies.options.success_deleted_option', 'Success deleted option.'));
    }
}
