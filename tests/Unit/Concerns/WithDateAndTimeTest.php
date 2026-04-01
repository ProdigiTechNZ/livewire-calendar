<?php

// phpcs:disable PEAR.Commenting.FunctionComment.Missing

use Prodigi\LivewireCalendar\LivewireCalendar;

final class WithDateAndTimeTestCalendar extends LivewireCalendar {

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

describe('weekends', function () {

    it('defaults to true', function () {
        expect((new WithDateAndTimeTestCalendar)->weekends())->toBeTrue();
    });

    it('can be set to false', function () {
        expect((new WithDateAndTimeTestCalendar)->showWeekends(false)->weekends())->toBeFalse();
    });

    it('can be set to true explicitly', function () {
        expect((new WithDateAndTimeTestCalendar)->showWeekends(true)->weekends())->toBeTrue();
    });

    it('returns static for chaining', function () {
        $cal = new WithDateAndTimeTestCalendar;
        expect($cal->showWeekends(false))->toBe($cal);
    });
});

describe('slotDuration', function () {

    it('defaults to 00:30:00', function () {
        expect((new WithDateAndTimeTestCalendar)->slotDuration())->toBe('00:30:00');
    });

    it('returns the value set via setSlotDuration()', function () {
        expect((new WithDateAndTimeTestCalendar)->setSlotDuration('01:00:00')->slotDuration())->toBe('01:00:00');
    });

    it('returns static for chaining', function () {
        $cal = new WithDateAndTimeTestCalendar;
        expect($cal->setSlotDuration('00:15:00'))->toBe($cal);
    });
});

describe('showNonCurrentDates', function () {

    it('defaults to true', function () {
        expect((new WithDateAndTimeTestCalendar)->showNonCurrentDates())->toBeTrue();
    });

    it('can be set to false', function () {
        expect((new WithDateAndTimeTestCalendar)->shouldShowNonCurrentDates(false)->showNonCurrentDates())->toBeFalse();
    });

    it('returns static for chaining', function () {
        $cal = new WithDateAndTimeTestCalendar;
        expect($cal->shouldShowNonCurrentDates(true))->toBe($cal);
    });
});

describe('fixedWeekCount', function () {

    it('defaults to true', function () {
        expect((new WithDateAndTimeTestCalendar)->fixedWeekCount())->toBeTrue();
    });

    it('can be set to false', function () {
        expect((new WithDateAndTimeTestCalendar)->setFixedWeekCount(false)->fixedWeekCount())->toBeFalse();
    });

    it('returns static for chaining', function () {
        $cal = new WithDateAndTimeTestCalendar;
        expect($cal->setFixedWeekCount(false))->toBe($cal);
    });
});

describe('slotMinTime', function () {

    it('defaults to 00:00:00', function () {
        expect((new WithDateAndTimeTestCalendar)->slotMinTime())->toBe('00:00:00');
    });

    it('returns the value set via setSlotMinTime()', function () {
        expect((new WithDateAndTimeTestCalendar)->setSlotMinTime('06:00:00')->slotMinTime())->toBe('06:00:00');
    });

    it('returns static for chaining', function () {
        $cal = new WithDateAndTimeTestCalendar;
        expect($cal->setSlotMinTime('08:00:00'))->toBe($cal);
    });
});

describe('slotMaxTime', function () {

    it('defaults to 24:00:00', function () {
        expect((new WithDateAndTimeTestCalendar)->slotMaxTime())->toBe('24:00:00');
    });

    it('returns the value set via setSlotMaxTime()', function () {
        expect((new WithDateAndTimeTestCalendar)->setSlotMaxTime('20:00:00')->slotMaxTime())->toBe('20:00:00');
    });

    it('returns static for chaining', function () {
        $cal = new WithDateAndTimeTestCalendar;
        expect($cal->setSlotMaxTime('22:00:00'))->toBe($cal);
    });
});
