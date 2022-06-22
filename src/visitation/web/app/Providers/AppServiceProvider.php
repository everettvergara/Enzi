<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::aliasComponent('components.text', 'text');
        Blade::aliasComponent('components.email', 'email');
        Blade::aliasComponent('components.badge', 'badge');
        Blade::aliasComponent('components.errors', 'errors');
        Blade::aliasComponent('components.alerts', 'alerts');
        Blade::aliasComponent('components.textarea', 'textarea');
        Blade::aliasComponent('components.password', 'password');
        Blade::aliasComponent('components.select', 'select');
        Blade::aliasComponent('components.select2', 'select2');
        Blade::aliasComponent('components.select-conditional', 'select_conditional');
        Blade::aliasComponent('components.searcher', 'searcher');
        Blade::aliasComponent('components.searcher-modal', 'searcher_modal');
        Blade::aliasComponent('components.searcher-js', 'searcher_js');

        Blade::aliasComponent('components.checkbox', 'checkbox');
        Blade::aliasComponent('components.datefield', 'datefield');
        Blade::aliasComponent('components.uploader', 'uploader');
        
        Blade::aliasComponent('components.rowmanager', 'rowmanager');
        Blade::aliasComponent('components.field', 'field');



        Blade::aliasComponent('layouts.old_nav', 'oldnav');
        Blade::aliasComponent('layouts.nav', 'nav');

        Paginator::useBootstrap();
    }
}