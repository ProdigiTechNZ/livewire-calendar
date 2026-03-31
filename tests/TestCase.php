<?php

namespace Prodigi\LivewireCalendar\Tests;

use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Prodigi\LivewireCalendar\LivewireCalendarServiceProvider;

abstract class TestCase extends BaseTestCase {

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array<int, class-string>
     *
     * @SuppressWarnings("UnusedFormalParameter")
     */
    protected function getPackageProviders($app): array {

        return [
            LivewireServiceProvider::class,
            LivewireCalendarServiceProvider::class,
        ];

    } //end getPackageProviders()

} //end class
