<?php

namespace Prodigi\LivewireCalendar\Tests\Support;

use Prodigi\LivewireCalendar\LivewireCalendar;

/**
 * Minimal concrete implementation for unit-testing traits on LivewireCalendar.
 * All abstract contract methods are no-ops; only the trait under test exercises real logic.
 */
final class ConcreteCalendar extends LivewireCalendar {

    /** @return array<mixed> */
    public function getEventsProperty(): array {

        return [];

    } //end getEventsProperty()

    /**
     * @param array<mixed> $info
     *
     * @SuppressWarnings("UnusedFormalParameter")
     */
    public function eventClick(array $info): void {

        // no-op — required by abstract contract; click handling is consumer responsibility

    } //end eventClick()

} //end class
