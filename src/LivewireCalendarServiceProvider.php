<?php

namespace Prodigi\LivewireCalendar;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LivewireCalendarServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('livewire-calendar')
            ->hasViews()
            ->hasConfigFile();
    }

    public function packageBooted(): void
    {
        Blade::directive('livewireCalendarScript', function () {
            return '<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>';
        });
    }
}
