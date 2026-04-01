<?php

namespace Prodigi\LivewireCalendar\Tests;

use Illuminate\Foundation\Application;
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

    /**
     * @param Application $app
     *
     * @SuppressWarnings("UnusedFormalParameter")
     */
    protected function defineEnvironment($app): void {

        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(32)));

    } //end defineEnvironment()

} //end class
