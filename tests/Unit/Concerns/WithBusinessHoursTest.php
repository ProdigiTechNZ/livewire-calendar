<?php

// phpcs:disable PEAR.Commenting.FunctionComment.Missing

use Prodigi\LivewireCalendar\Tests\Support\ConcreteCalendar;

describe('businessHours', function () {

    it('defaults to an empty array', function () {
        $calendar = new ConcreteCalendar;

        expect($calendar->businessHours())->toBe([]);
    });

    it('returns the value set via setBusinessHours()', function () {
        $hours    = [['daysOfWeek' => [1, 2, 3], 'startTime' => '09:00', 'endTime' => '17:00']];
        $calendar = new ConcreteCalendar;
        $calendar->setBusinessHours($hours);

        expect($calendar->businessHours())->toBe($hours);
    });

    it('reverts to empty array when called with no argument', function () {
        $hours    = [['daysOfWeek' => [1], 'startTime' => '08:00', 'endTime' => '16:00']];
        $calendar = (new ConcreteCalendar)
            ->setBusinessHours($hours)
            ->setBusinessHours();

        expect($calendar->businessHours())->toBe([]);
    });

    it('returns static for method chaining', function () {
        $calendar = new ConcreteCalendar;

        expect($calendar->setBusinessHours([]))->toBe($calendar);
    });
});
