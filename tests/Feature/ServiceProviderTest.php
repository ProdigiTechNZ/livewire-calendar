<?php

// phpcs:disable PEAR.Commenting.FunctionComment.Missing

use Illuminate\Support\Facades\Blade;

describe('service provider', function () {

    it('registers the livewire-calendar config', function () {
        expect(config('livewire-calendar'))->toBeArray();
    });

    it('registers the livewire-calendar views', function () {
        // find() throws InvalidArgumentException if the namespace is not registered
        $path = app('view')->getFinder()->find('livewire-calendar::calendar');

        expect($path)->toEndWith('.blade.php');
    });

    it('registers the @livewireCalendarScript blade directive', function () {
        $output = Blade::render('@livewireCalendarScript');

        expect($output)->toContain('cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js')
            ->and($output)->toContain('<script');
    });
});
