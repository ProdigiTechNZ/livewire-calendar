<?php

namespace Prodigi\LivewireCalendar;

use Prodigi\LivewireCalendar\Concerns\WithBusinessHours;
use Prodigi\LivewireCalendar\Concerns\WithDateAndTime;
use Prodigi\LivewireCalendar\Concerns\WithDateNavigation;
use Prodigi\LivewireCalendar\Concerns\WithEventDisplay;
use Prodigi\LivewireCalendar\Concerns\WithLocale;
use Prodigi\LivewireCalendar\Concerns\WithNow;
use Prodigi\LivewireCalendar\Concerns\WithToolbar;
use Prodigi\LivewireCalendar\Concerns\WithView;
use Livewire\Component;

abstract class LivewireCalendar extends Component
{
    use WithBusinessHours;
    use WithDateAndTime;
    use WithDateNavigation;
    use WithEventDisplay;
    use WithLocale;
    use WithNow;
    use WithToolbar;
    use WithView;

    abstract public function getEventsProperty(): array;

    abstract public function eventClick($info): void;

    public function booted(): void
    {
        $this->config();
    }

    public function config(): void
    {
        //
    }

    public function render()
    {
        return view('livewire-calendar::calendar');
    }
}
