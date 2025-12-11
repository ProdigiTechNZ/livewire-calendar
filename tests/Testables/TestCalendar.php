<?php

namespace Prodigi\LivewireCalendar\Tests\Testables;

use Prodigi\LivewireCalendar\LivewireCalendar;

final class TestCalendar extends LivewireCalendar {

    public function getEventsProperty(): array {

        return [];

    } //end getEventsProperty()

    public function eventClick($info): void {

    } //end eventClick()

} //end class
