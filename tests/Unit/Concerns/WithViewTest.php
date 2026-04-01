<?php

// phpcs:disable PEAR.Commenting.FunctionComment.Missing

use Prodigi\LivewireCalendar\Tests\Support\ConcreteCalendar;

describe('initialView', function () {

    it('defaults to dayGridMonth', function () {
        $calendar = new ConcreteCalendar;

        expect($calendar->initialView())->toBe('dayGridMonth');
    });

    it('returns the value set via setInitialView()', function () {
        $calendar = (new ConcreteCalendar)->setInitialView('timeGridWeek');

        expect($calendar->initialView())->toBe('timeGridWeek');
    });

    it('reverts to default when called with no argument', function () {
        $calendar = (new ConcreteCalendar)
            ->setInitialView('listWeek')
            ->setInitialView();

        expect($calendar->initialView())->toBe('dayGridMonth');
    });

    it('returns static for method chaining', function () {
        $calendar = new ConcreteCalendar;

        expect($calendar->setInitialView('listDay'))->toBe($calendar);
    });
});
