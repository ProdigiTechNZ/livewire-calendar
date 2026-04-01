<?php

// phpcs:disable PEAR.Commenting.FunctionComment.Missing

use Prodigi\LivewireCalendar\Tests\Support\ConcreteCalendar;

describe('locale', function () {

    it('falls back to app.locale config when not set', function () {
        config(['app.locale' => 'fr']);

        expect((new ConcreteCalendar)->locale())->toBe('fr');
    });

    it('returns the value set via setLocale()', function () {
        expect((new ConcreteCalendar)->setLocale('de')->locale())->toBe('de');
    });

    it('defaults setLocale() to en when called with no argument', function () {
        expect((new ConcreteCalendar)->setLocale()->locale())->toBe('en');
    });

    it('returns static for chaining', function () {
        $cal = new ConcreteCalendar;
        expect($cal->setLocale('es'))->toBe($cal);
    });
});

describe('timeZone', function () {

    it('falls back to app.timezone config when not set', function () {
        config(['app.timezone' => 'Pacific/Auckland']);

        expect((new ConcreteCalendar)->timeZone())->toBe('Pacific/Auckland');
    });

    it('returns the value set via setTimeZone()', function () {
        expect((new ConcreteCalendar)->setTimeZone('UTC')->timeZone())->toBe('UTC');
    });

    it('defaults setTimeZone() to local when called with no argument', function () {
        expect((new ConcreteCalendar)->setTimeZone()->timeZone())->toBe('local');
    });

    it('returns static for chaining', function () {
        $cal = new ConcreteCalendar;
        expect($cal->setTimeZone('UTC'))->toBe($cal);
    });
});

describe('firstDay', function () {

    it('defaults to 0 (Sunday)', function () {
        expect((new ConcreteCalendar)->firstDay())->toBe(0);
    });

    it('returns the value set via setFirstDay()', function () {
        expect((new ConcreteCalendar)->setFirstDay(1)->firstDay())->toBe(1);
    });

    it('returns static for chaining', function () {
        $cal = new ConcreteCalendar;
        expect($cal->setFirstDay(1))->toBe($cal);
    });
});
