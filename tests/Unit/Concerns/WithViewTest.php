<?php

// phpcs:disable PEAR.Commenting.FunctionComment.Missing

use Prodigi\LivewireCalendar\LivewireCalendar;

// Minimal concrete fixture shared across concern tests
final class WithViewTestCalendar extends LivewireCalendar {

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

        // no-op

    } //end eventClick()

} //end class

describe('initialView', function () {

    it('defaults to dayGridMonth', function () {
        $calendar = new WithViewTestCalendar;

        expect($calendar->initialView())->toBe('dayGridMonth');
    });

    it('returns the value set via setInitialView()', function () {
        $calendar = (new WithViewTestCalendar)->setInitialView('timeGridWeek');

        expect($calendar->initialView())->toBe('timeGridWeek');
    });

    it('reverts to default when called with no argument', function () {
        $calendar = (new WithViewTestCalendar)
            ->setInitialView('listWeek')
            ->setInitialView();

        expect($calendar->initialView())->toBe('dayGridMonth');
    });

    it('returns static for method chaining', function () {
        $calendar = new WithViewTestCalendar;

        expect($calendar->setInitialView('listDay'))->toBe($calendar);
    });
});
