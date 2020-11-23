<?php

namespace AwemaPL\Subscription;

use AwemaPL\BaseJS\AwemaProvider;
use AwemaPL\Navigation\Middlewares\AddNavigationComponent;
use AwemaPL\Subscription\Sections\Creators\Repositories\Contracts\HistoryRepository;
use AwemaPL\Subscription\Sections\Creators\Repositories\EloquentHistoryRepository;
use AwemaPL\Subscription\Sections\Installations\Http\Middleware\GlobalMiddleware;
use AwemaPL\Subscription\Sections\Installations\Http\Middleware\GroupMiddleware;
use AwemaPL\Subscription\Sections\Installations\Http\Middleware\Installation;
use AwemaPL\Subscription\Sections\Installations\Http\Middleware\RouteMiddleware;
use AwemaPL\Subscription\Contracts\Subscription as SubscriptionContract;
use AwemaPL\Subscription\Sections\Memberships\Repositories\Contracts\MembershipRepository;
use AwemaPL\Subscription\Sections\Memberships\Repositories\Contracts\UserRepository;
use AwemaPL\Subscription\Sections\Memberships\Repositories\EloquentMembershipRepository;
use AwemaPL\Subscription\Sections\Memberships\Repositories\EloquentUserRepository;
use AwemaPL\Subscription\Sections\Options\Repositories\Contracts\OptionRepository;
use AwemaPL\Subscription\Sections\Options\Repositories\EloquentOptionRepository;
use AwemaPL\Subscription\Sections\Subscriptions\Repositories\Contracts\SubscriptionRepository;
use AwemaPL\Subscription\Sections\Subscriptions\Repositories\EloquentSubscriptionRepository;
use Illuminate\Support\Facades\Cache;

class SubscriptionServiceProvider extends AwemaProvider
{

    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'subscription');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'subscription');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->bootMiddleware();
        app('subscription')->includeLangJs();
        app('subscription')->menuMerge();
        app('subscription')->mergePermissions();
        parent::boot();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/subscription.php', 'subscription');
        $this->mergeConfigFrom(__DIR__ . '/../config/subscription-menu.php', 'subscription-menu');
        $this->app->bind(SubscriptionContract::class, Subscription::class);
        $this->app->singleton('subscription', SubscriptionContract::class);
        $this->registerRepositories();
        app('subscription')->registerUserHasSucription();
        parent::register();
    }


    public function getPackageName(): string
    {
        return 'subscription';
    }

    public function getPath(): string
    {
        return __DIR__;
    }

    /**
     * Register and bind package repositories
     *
     * @return void
     */
    protected function registerRepositories()
    {
        $this->app->bind(HistoryRepository::class, EloquentHistoryRepository::class);
        $this->app->bind(MembershipRepository::class, EloquentMembershipRepository::class);
        $this->app->bind(OptionRepository::class, EloquentOptionRepository::class);
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
    }

    /**
     * Boot middleware
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function bootMiddleware()
    {
        $this->bootGlobalMiddleware();
        $this->bootRouteMiddleware();
        $this->bootGroupMiddleware();
    }

    /**
     * Boot route middleware
     */
    private function bootRouteMiddleware()
    {
        $router = app('router');
        $router->aliasMiddleware('subscription', RouteMiddleware::class);
    }

    /**
     * Boot group middleware
     */
    private function bootGroupMiddleware()
    {
        $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);
        $kernel->appendMiddlewareToGroup('web', GroupMiddleware::class);
        $kernel->appendMiddlewareToGroup('web', Installation::class);
    }

    /**
     * Boot global middleware
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function bootGlobalMiddleware()
    {
        $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);
        $kernel->pushMiddleware(GlobalMiddleware::class);
    }


}
