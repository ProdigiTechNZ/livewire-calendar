<?php

use Livewire\Livewire;
use Prodigi\LivewireCalendar\Tests\Testables\TestCalendar;

it('mounts the component', function () {
    Livewire::Test(TestCalendar::class)
        ->assertStatus(200);
});
