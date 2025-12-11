<?php

namespace Prodigi\LivewireCalendar\Tests\Testables;

use Prodigi\LivewireCalendar\LivewireCalendar;

/**
 * original author didn't bother with function comments
 *
 * phpcs:disable PEAR.Commenting.FunctionComment.Missing
 *
 * @SuppressWarnings("UnusedFormalParameter")
 */
final class TestCalendar extends LivewireCalendar {

    public function getEventsProperty(): array {

        return [];

    } //end getEventsProperty()

    /**
     * handle clicks (this is all abstracted away internally)
     *
     * @param array{event: array<mixed>, jsEvent: array<mixed>, view: array<mixed>} $info
     */
    public function eventClick(array $info): void {

        // not implemented

    } //end eventClick()

} //end class
