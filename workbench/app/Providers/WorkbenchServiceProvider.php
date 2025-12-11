<?php

namespace Workbench\App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

final class WorkbenchServiceProvider extends ServiceProvider {

    /**
     * Register services.
     */
    public function register(): void {

        // not implemented

    } //end register()

    /**
     * Bootstrap services.
     */
    public function boot(): void {

        Route::view('/', 'welcome');

    } //end boot()

} //end class
