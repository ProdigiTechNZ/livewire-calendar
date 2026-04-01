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

    // NOTE: initialDate() declares return type string but returns Carbon objects,
    // relying on implicit Carbon::__toString() coercion. Tests assert the actual
    // coerced-string behaviour. Source should call ->format()/'->toDateTimeString()
    // explicitly — tracked as a source bug for Phase 6.

    it('returns a date string when no date is set', function () {
        $result = (new WithDateNavigationTestCalendar)->initialDate();

        expect($result)->toBeString();
    });

    it('returns the string form of the Carbon instance set via setInitialDate()', function () {
        $date   = Carbon::parse('2025-06-15');
        $result = (new WithDateNavigationTestCalendar)->setInitialDate($date)->initialDate();

        expect($result)->toBe((string) $date);
    });

    it('reverts to a current-date string when setInitialDate called with null', function () {
        $date   = Carbon::parse('2025-01-01');
        $result = (new WithDateNavigationTestCalendar)
            ->setInitialDate($date)
            ->setInitialDate(null)
            ->initialDate();

        expect($result)->toBeString()->not->toBeEmpty();
    });

    it('returns static for chaining', function () {
        $cal = new WithDateNavigationTestCalendar;

        expect($cal->setInitialDate(null))->toBe($cal);
    });
});
