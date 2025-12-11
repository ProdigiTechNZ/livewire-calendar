<?php

namespace Prodigi\LivewireCalendar\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Livewire\Livewire;
use Orchestra\Testbench\TestCase as Orchestra;
use Prodigi\LivewireCalendar\LivewireCalendar;
use Prodigi\LivewireCalendar\LivewireCalendarServiceProvider;

final class TestCase extends Orchestra {

    public function getEnvironmentSetUp($app): void {

        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_livewire-calendar_table.php.stub';
        $migration->up();
        */

    } //end getEnvironmentSetUp()

    protected function setUp(): void {

        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Prodigi\\LivewireCalendar\\Database\\Factories\\'.class_basename(
                $modelName,
            ).'Factory',
        );

        $this->registerLivewireComponents();

    } //end setUp()

    protected function getPackageProviders($app): array {

        return [
            \Livewire\LivewireServiceProvider::class,
            LivewireCalendarServiceProvider::class,
        ];

    } //end getPackageProviders()

    protected function registerLivewireComponents(): void {

        Livewire::component('livewire-calendar', LiveWireCalendar::class);

    } //end registerLivewireComponents()

} //end class
