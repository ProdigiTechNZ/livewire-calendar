<?php

// phpcs:disable PEAR.Commenting.FunctionComment.Missing

use Carbon\Carbon;
use Prodigi\LivewireCalendar\LivewireCalendar;

final class WithDateNavigationTestCalendar extends LivewireCalendar {

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

describe('initialDate', function () {

    it('returns the current datetime string when no date is set', function () {
        $result = (new WithDateNavigationTestCalendar)->initialDate();

        expect($result)->toBeString()->toMatch('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/');
    });

    it('returns the datetime string of the Carbon instance set via setInitialDate()', function () {
        $date   = Carbon::parse('2025-06-15 09:00:00');
        $result = (new WithDateNavigationTestCalendar)->setInitialDate($date)->initialDate();

        expect($result)->toBe('2025-06-15 09:00:00');
    });

    it('reverts to current datetime string when setInitialDate called with null', function () {
        $date   = Carbon::parse('2025-01-01');
        $result = (new WithDateNavigationTestCalendar)
            ->setInitialDate($date)
            ->setInitialDate(null)
            ->initialDate();

        expect($result)->toMatch('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/');
    });

    it('returns static for chaining', function () {
        $cal = new WithDateNavigationTestCalendar;

        expect($cal->setInitialDate(null))->toBe($cal);
    });
});
