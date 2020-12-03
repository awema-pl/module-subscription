<?php

namespace AwemaPL\Subscription;

use Illuminate\Database\Migrations\Migrator;
use Illuminate\Routing\Router;
use AwemaPL\Subscription\Contracts\Subscription as SubscriptionContract;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Subscription implements SubscriptionContract
{
    /** @var Router $router */
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Routes
     */
    public function routes()
    {
        if ($this->isActiveRoutes()) {
            if ($this->isActiveInstallationRoutes()) {
                $this->installationRoutes();
            }
            if ($this->isActiveOptionRoutes()) {
                $this->optionRoutes();
            }
            if ($this->isActiveMembershipRoutes()) {
                $this->membershipRoutes();
            }
        }
    }

    /**
     * Installation routes
     */
    protected function installationRoutes()
    {
        $prefix = config('subscription.routes.installation.prefix');
        $namePrefix = config('subscription.routes.installation.name_prefix');
        $this->router->prefix($prefix)->name($namePrefix)->group(function () {
            $this->router
                ->get('/', '\AwemaPL\Subscription\Sections\Installations\Http\Controllers\InstallationController@index')
                ->name('index');
            $this->router->post('/', '\AwemaPL\Subscription\Sections\Installations\Http\Controllers\InstallationController@store')
                ->name('store');
        });

    }

    /**
     * Option routes
     */
    protected function optionRoutes()
    {

        $prefix = config('subscription.routes.option.prefix');
        $namePrefix = config('subscription.routes.option.name_prefix');
        $middleware = config('subscription.routes.option.middleware');
        $this->router->prefix($prefix)->name($namePrefix)->middleware($middleware)->group(function () {
            $this->router
                ->get('/', '\AwemaPL\Subscription\Sections\Options\Http\Controllers\OptionController@index')
                ->name('index');
            $this->router
                ->post('/', '\AwemaPL\Subscription\Sections\Options\Http\Controllers\OptionController@store')
                ->name('store');
            $this->router
                ->get('/options', '\AwemaPL\Subscription\Sections\Options\Http\Controllers\OptionController@scope')
                ->name('scope');
            $this->router
                ->patch('{id?}', '\AwemaPL\Subscription\Sections\Options\Http\Controllers\OptionController@update')
                ->name('update');
            $this->router
                ->delete('{id?}', '\AwemaPL\Subscription\Sections\Options\Http\Controllers\OptionController@delete')
                ->name('delete');
        });
    }

    /**
     * Membership routes
     */
    protected function membershipRoutes()
    {
        $prefix = config('subscription.routes.membership.prefix');
        $namePrefix = config('subscription.routes.membership.name_prefix');
        $middleware = config('subscription.routes.membership.middleware');
        $this->router->prefix($prefix)->name($namePrefix)->middleware($middleware)->group(function () {
            $this->router
                ->get('/', '\AwemaPL\Subscription\Sections\Memberships\Http\Controllers\MembershipController@index')
                ->name('index');
            $this->router
                ->post('/', '\AwemaPL\Subscription\Sections\Memberships\Http\Controllers\MembershipController@store')
                ->name('store');
            $this->router
                ->get('/memberships', '\AwemaPL\Subscription\Sections\Memberships\Http\Controllers\MembershipController@scope')
                ->name('scope');
            $this->router
                ->get('/users', '\AwemaPL\Subscription\Sections\Memberships\Http\Controllers\MembershipController@scopeUsers')
                ->name('scope_users');
            $this->router
                ->patch('{id?}', '\AwemaPL\Subscription\Sections\Memberships\Http\Controllers\MembershipController@update')
                ->name('update');
            $this->router
                ->delete('{id?}', '\AwemaPL\Subscription\Sections\Memberships\Http\Controllers\MembershipController@delete')
                ->name('delete');
        });
    }

    /**
     * Can installation
     *
     * @return bool
     */
    public function canInstallation()
    {
        $canForPermission = $this->canInstallForPermission();
        return $this->isActiveRoutes()
            && $this->isActiveInstallationRoutes()
            && $canForPermission
            && !$this->isMigrated();
    }

    /**
     * Is migrated
     *
     * @return bool
     */
    public function isMigrated()
    {
        $tablesInDb = array_map('reset', \DB::select('SHOW TABLES'));

        $tables = array_values(config('subscription.database.tables'));
        foreach ($tables as $table){
            if (!in_array($table, $tablesInDb)){
                return false;
            }
        }
        return true;
    }

    /**
     * Is active routes
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public function isActiveRoutes()
    {
        return config('subscription.routes.active');
    }

    /**
     * Is active installation routes
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private function isActiveInstallationRoutes()
    {
        return config('subscription.routes.installation.active');
    }

    /**
     * Is active member routes
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private function isActiveMembershipRoutes()
    {
        return config('subscription.routes.membership.active');
    }

    /**
     * Is active option routes
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private function isActiveOptionRoutes()
    {
        return config('subscription.routes.option.active');
    }

    /**
     * Include lang JS
     */
    public function includeLangJs()
    {
        $lang = config('indigo-layout.frontend.lang', []);
        $lang = array_merge_recursive($lang, app(\Illuminate\Contracts\Translation\Translator::class)->get('subscription::js')?:[]);
        app('config')->set('indigo-layout.frontend.lang', $lang);
    }

    /**
     * Can install for permission
     *
     * @return bool
     */
    private function canInstallForPermission()
    {
        $userClass = config('auth.providers.users.model');
        if (!method_exists($userClass, 'hasRole')) {
            return true;
        }

        if ($user = request()->user() ?? null){
            return $user->can(config('subscription.installation.auto_redirect.permission'));
        }

        return false;
    }

    /**
     * Menu merge in navigation
     */
    public function menuMerge()
    {
        if ($this->canMergeMenu()){
            $subscriptionMenu = config('subscription-menu.navs', []);
            $navTemp = config('temp_navigation.navs', []);
            $nav = array_merge_recursive($navTemp, $subscriptionMenu);
            config(['temp_navigation.navs' => $nav]);
        }
    }

    /**
     * Can merge menu
     *
     * @return boolean
     */
    private function canMergeMenu()
    {
        return !!config('subscription-menu.merge_to_navigation') && self::isMigrated();
    }

    /**
     * Execute package migrations
     */
    public function migrate()
    {
         Artisan::call('migrate', ['--force' => true, '--path'=>'vendor/awema-pl/module-subscription/database/migrations']);
    }

    /**
     * Install package
     */
    public function install()
    {
        $this->migrate();
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
    }

    /**
     * Add permissions for module permission
     */
    public function mergePermissions()
    {
        if ($this->canMergePermissions()){
            $subscriptionPermissions = config('subscription.permissions');
            $tempPermissions = config('temp_permission.permissions', []);
            $permissions = array_merge_recursive($tempPermissions, $subscriptionPermissions);
            config(['temp_permission.permissions' => $permissions]);
        }
    }

    /**
     * Can merge permissions
     *
     * @return boolean
     */
    private function canMergePermissions()
    {
        return !!config('subscription.merge_permissions');
    }

    /**
     * Register user has subscription
     *
     * @throws \ReflectionException
     */
    public function registerUserHasSucription()
    {
        $userClass = config('auth.providers.users.model');
        if (!method_exists($userClass, 'membership')) {
            $reflector = new \ReflectionClass($userClass);
            $path= $reflector->getFileName();
            $content = File::get($path);
            if (!Str::contains($content, 'use \AwemaPL\Subscription\Traits\HasSubscription;')){
                $content = Str::replaceFirst('{', '{' . PHP_EOL . PHP_EOL . "\t" . 'use \AwemaPL\Subscription\Traits\HasSubscription;', $content);
                File::put($path, $content);
            }
        }
    }
}
