<?php

// phpcs:disable PEAR.Commenting.FunctionComment.Missing

use Prodigi\LivewireCalendar\Tests\Support\ConcreteCalendar;

describe('displayEventEnd', function () {

    it('defaults to true', function () {
        expect((new ConcreteCalendar)->displayEventEnd())->toBeTrue();
    });

    it('can be set to false', function () {
        expect((new ConcreteCalendar)->setDisplayEventEnd(false)->displayEventEnd())->toBeFalse();
    });

    it('can be set to true explicitly', function () {
        expect((new ConcreteCalendar)->setDisplayEventEnd(true)->displayEventEnd())->toBeTrue();
    });

    it('reverts to true when called with no argument', function () {
        expect(
            (new ConcreteCalendar)->setDisplayEventEnd(false)->setDisplayEventEnd()->displayEventEnd(),
        )->toBeTrue();
    });

    it('returns static for chaining', function () {
        $cal = new ConcreteCalendar;
        expect($cal->setDisplayEventEnd(false))->toBe($cal);
    });
});

describe('displayEventTime', function () {

    it('defaults to true', function () {
        expect((new ConcreteCalendar)->displayEventTime())->toBeTrue();
    });

    it('can be set to false', function () {
        expect((new ConcreteCalendar)->setDisplayEventTime(false)->displayEventTime())->toBeFalse();
    });

    it('can be set to true explicitly', function () {
        expect((new ConcreteCalendar)->setDisplayEventTime(true)->displayEventTime())->toBeTrue();
    });

    it('reverts to true when called with no argument', function () {
        expect(
            (new ConcreteCalendar)->setDisplayEventTime(false)->setDisplayEventTime()->displayEventTime(),
        )->toBeTrue();
    });

    it('returns static for chaining', function () {
        $cal = new ConcreteCalendar;
        expect($cal->setDisplayEventTime(false))->toBe($cal);
    });
});
