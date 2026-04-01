<?php

// phpcs:disable PEAR.Commenting.FunctionComment.Missing

use Prodigi\LivewireCalendar\Tests\Support\ConcreteCalendar;

describe('weekends', function () {

    it('defaults to true', function () {
        expect((new ConcreteCalendar)->weekends())->toBeTrue();
    });

    it('can be set to false', function () {
        expect((new ConcreteCalendar)->showWeekends(false)->weekends())->toBeFalse();
    });

    it('can be set to true explicitly', function () {
        expect((new ConcreteCalendar)->showWeekends(true)->weekends())->toBeTrue();
    });

    it('returns static for chaining', function () {
        $cal = new ConcreteCalendar;
        expect($cal->showWeekends(false))->toBe($cal);
    });
});

describe('slotDuration', function () {

    it('defaults to 00:30:00', function () {
        expect((new ConcreteCalendar)->slotDuration())->toBe('00:30:00');
    });

    it('returns the value set via setSlotDuration()', function () {
        expect((new ConcreteCalendar)->setSlotDuration('01:00:00')->slotDuration())->toBe('01:00:00');
    });

    it('returns static for chaining', function () {
        $cal = new ConcreteCalendar;
        expect($cal->setSlotDuration('00:15:00'))->toBe($cal);
    });
});

describe('showNonCurrentDates', function () {

    it('defaults to true', function () {
        expect((new ConcreteCalendar)->showNonCurrentDates())->toBeTrue();
    });

    it('can be set to false', function () {
        expect((new ConcreteCalendar)->shouldShowNonCurrentDates(false)->showNonCurrentDates())->toBeFalse();
    });

    it('can be set to true', function () {
        expect((new ConcreteCalendar)->shouldShowNonCurrentDates(true)->showNonCurrentDates())->toBeTrue();
    });

    it('returns static for chaining', function () {
        $cal = new ConcreteCalendar;
        expect($cal->shouldShowNonCurrentDates(true))->toBe($cal);
    });
});

describe('fixedWeekCount', function () {

    it('defaults to true', function () {
        expect((new ConcreteCalendar)->fixedWeekCount())->toBeTrue();
    });

    it('can be set to false', function () {
        expect((new ConcreteCalendar)->setFixedWeekCount(false)->fixedWeekCount())->toBeFalse();
    });

    it('returns static for chaining', function () {
        $cal = new ConcreteCalendar;
        expect($cal->setFixedWeekCount(false))->toBe($cal);
    });
});

describe('slotMinTime', function () {

    it('defaults to 00:00:00', function () {
        expect((new ConcreteCalendar)->slotMinTime())->toBe('00:00:00');
    });

    it('returns the value set via setSlotMinTime()', function () {
        expect((new ConcreteCalendar)->setSlotMinTime('06:00:00')->slotMinTime())->toBe('06:00:00');
    });

    it('returns static for chaining', function () {
        $cal = new ConcreteCalendar;
        expect($cal->setSlotMinTime('08:00:00'))->toBe($cal);
    });
});

describe('slotMaxTime', function () {

    it('defaults to 24:00:00', function () {
        expect((new ConcreteCalendar)->slotMaxTime())->toBe('24:00:00');
    });

    it('returns the value set via setSlotMaxTime()', function () {
        expect((new ConcreteCalendar)->setSlotMaxTime('20:00:00')->slotMaxTime())->toBe('20:00:00');
    });

    it('returns static for chaining', function () {
        $cal = new ConcreteCalendar;
        expect($cal->setSlotMaxTime('22:00:00'))->toBe($cal);
    });
});
