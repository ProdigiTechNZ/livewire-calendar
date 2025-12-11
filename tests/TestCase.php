<?php

namespace Prodigi\LivewireCalendar\Tests;

use Prodigi\LivewireCalendar\LivewireCalendar;
use Prodigi\LivewireCalendar\LivewireCalendarServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Livewire\Livewire;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Prodigi\\LivewireCalendar\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        $this->registerLivewireComponents();
    }

    protected function getPackageProviders($app): array
    {
        return [
            \Livewire\LivewireServiceProvider::class,
            LivewireCalendarServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_livewire-calendar_table.php.stub';
        $migration->up();
        */
    }

    protected function registerLivewireComponents(): void
    {
        Livewire::component('livewire-calendar', LiveWireCalendar::class);
    }
}
