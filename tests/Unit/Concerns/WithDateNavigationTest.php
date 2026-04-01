<?php

// phpcs:disable PEAR.Commenting.FunctionComment.Missing

use Carbon\Carbon;
use Prodigi\LivewireCalendar\Tests\Support\ConcreteCalendar;

beforeEach(fn () => Carbon::setTestNow(Carbon::parse('2025-04-01 12:00:00')));
afterEach(fn () => Carbon::setTestNow(null));

describe('initialDate', function () {

    it('returns the current datetime string when no date is set', function () {
        $result = (new ConcreteCalendar)->initialDate();

        expect($result)->toBe('2025-04-01 12:00:00');
    });

    it('returns the datetime string of the Carbon instance set via setInitialDate()', function () {
        $date   = Carbon::parse('2025-06-15 09:00:00');
        $result = (new ConcreteCalendar)->setInitialDate($date)->initialDate();

        expect($result)->toBe('2025-06-15 09:00:00');
    });

    it('reverts to current datetime string when setInitialDate called with null', function () {
        $date   = Carbon::parse('2025-01-01');
        $result = (new ConcreteCalendar)
            ->setInitialDate($date)
            ->setInitialDate(null)
            ->initialDate();

        expect($result)->toBe('2025-04-01 12:00:00');
    });

    it('returns static for chaining', function () {
        $cal = new ConcreteCalendar;

        expect($cal->setInitialDate(null))->toBe($cal);
    });
});
