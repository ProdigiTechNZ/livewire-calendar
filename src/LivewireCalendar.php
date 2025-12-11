<?php

namespace Prodigi\LivewireCalendar;

use Illuminate\View\View;
use Livewire\Component;
use Prodigi\LivewireCalendar\Concerns\WithBusinessHours;
use Prodigi\LivewireCalendar\Concerns\WithDateAndTime;
use Prodigi\LivewireCalendar\Concerns\WithDateNavigation;
use Prodigi\LivewireCalendar\Concerns\WithEventDisplay;
use Prodigi\LivewireCalendar\Concerns\WithLocale;
use Prodigi\LivewireCalendar\Concerns\WithNow;
use Prodigi\LivewireCalendar\Concerns\WithToolbar;
use Prodigi\LivewireCalendar\Concerns\WithView;

/**
 * FullCalendar documentation (quite good) at: https://fullcalendar.io/docs/
 *
 * original author didn't bother with function comments
 *
 * phpcs:disable PEAR.Commenting.FunctionComment.Missing
 */
abstract class LivewireCalendar extends Component {

    use WithBusinessHours;
    use WithDateAndTime;
    use WithDateNavigation;
    use WithEventDisplay;
    use WithLocale;
    use WithNow;
    use WithToolbar;
    use WithView;

    /**
     * internal abstractions
     *
     * @return array<mixed>
     */
    abstract public function getEventsProperty(): array;

    /**
     * handle clicks (this is all abstracted away internally)
     *
     * @param array{event: array<mixed>, jsEvent: array<mixed>, view: array<mixed>} $info
     */
    abstract public function eventClick(array $info): void;

    public function booted(): void {

        $this->config();

    } //end booted()

    public function config(): void {

        // not implemented

    } //end config()

    public function render(): View {

        return view('livewire-calendar::calendar');

    } //end render()

} //end class
