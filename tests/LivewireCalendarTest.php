<?php

use Prodigi\LivewireCalendar\Tests\Testables\TestCalendar;
use Livewire\Livewire;

it('mounts the component', function () {
    Livewire::Test(TestCalendar::class)
        ->assertStatus(200);
});
