<?php

// phpcs:disable PEAR.Commenting.FunctionComment.Missing

use Prodigi\LivewireCalendar\LivewireCalendar;

final class WithLocaleTestCalendar extends LivewireCalendar {

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

describe('locale', function () {

    it('falls back to app.locale config when not set', function () {
        config(['app.locale' => 'fr']);

        expect((new WithLocaleTestCalendar)->locale())->toBe('fr');
    });

    it('returns the value set via setLocale()', function () {
        expect((new WithLocaleTestCalendar)->setLocale('de')->locale())->toBe('de');
    });

    it('defaults setLocale() to en when called with no argument', function () {
        expect((new WithLocaleTestCalendar)->setLocale()->locale())->toBe('en');
    });

    it('returns static for chaining', function () {
        $cal = new WithLocaleTestCalendar;
        expect($cal->setLocale('es'))->toBe($cal);
    });
});

describe('timeZone', function () {

    it('falls back to app.timezone config when not set', function () {
        config(['app.timezone' => 'Pacific/Auckland']);

        expect((new WithLocaleTestCalendar)->timeZone())->toBe('Pacific/Auckland');
    });

    it('returns the value set via setTimeZone()', function () {
        expect((new WithLocaleTestCalendar)->setTimeZone('UTC')->timeZone())->toBe('UTC');
    });

    it('defaults setTimeZone() to local when called with no argument', function () {
        expect((new WithLocaleTestCalendar)->setTimeZone()->timeZone())->toBe('local');
    });

    it('returns static for chaining', function () {
        $cal = new WithLocaleTestCalendar;
        expect($cal->setTimeZone('UTC'))->toBe($cal);
    });
});

describe('firstDay', function () {

    it('defaults to 0 (Sunday)', function () {
        expect((new WithLocaleTestCalendar)->firstDay())->toBe(0);
    });

    it('returns the value set via setFirstDay()', function () {
        expect((new WithLocaleTestCalendar)->setFirstDay(1)->firstDay())->toBe(1);
    });

    it('returns static for chaining', function () {
        $cal = new WithLocaleTestCalendar;
        expect($cal->setFirstDay(1))->toBe($cal);
    });
});
