<?php

namespace AwemaPL\Subscription\Contracts;

interface Subscription
{
    /**
     * Register routes.
     *
     * @return void
     */
    public function routes();

    /**
     * Can installation
     *
     * @return mixed
     */
    public function canInstallation();

    /**
     * Include Lang JS
     */
    public function includeLangJs();


    /**
     * Menu merge in navigation
     */
    public function menuMerge();

    /**
     * Install package
     */
    public function install();

    /**
     * Add permissions for module permission
     *
     * @return mixed
     */
    public function mergePermissions();

    /**
     * Register user has subscription
     *
     * @throws \ReflectionException
     */
    public function registerUserHasSucription();

    /**
     * Add widgets
     */
    public function addWidgets();
}
