<?php

// phpcs:disable PEAR.Commenting.FunctionComment.Missing

use Prodigi\LivewireCalendar\Tests\Support\ConcreteCalendar;

describe('now', function () {

    it('defaults to true', function () {
        expect((new ConcreteCalendar)->now())->toBeTrue();
    });

    it('can be set to false', function () {
        expect((new ConcreteCalendar)->showNow(false)->now())->toBeFalse();
    });

    it('can be set to true explicitly', function () {
        expect((new ConcreteCalendar)->showNow(true)->now())->toBeTrue();
    });

    it('reverts to true when called with no argument', function () {
        expect((new ConcreteCalendar)->showNow(false)->showNow()->now())->toBeTrue();
    });

    it('returns static for chaining', function () {
        $cal = new ConcreteCalendar;
        expect($cal->showNow(false))->toBe($cal);
    });
});

describe('nowIndicator', function () {

    it('defaults to false', function () {
        expect((new ConcreteCalendar)->nowIndicator())->toBeFalse();
    });

    it('can be set to true', function () {
        expect((new ConcreteCalendar)->showNowIndicator(true)->nowIndicator())->toBeTrue();
    });

    it('can be set to false explicitly', function () {
        expect((new ConcreteCalendar)->showNowIndicator(false)->nowIndicator())->toBeFalse();
    });

    it('reverts to true when called with no argument', function () {
        expect((new ConcreteCalendar)->showNowIndicator()->nowIndicator())->toBeTrue();
    });

    it('returns static for chaining', function () {
        $cal = new ConcreteCalendar;
        expect($cal->showNowIndicator(true))->toBe($cal);
    });
});
