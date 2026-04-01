<?php

// phpcs:disable PEAR.Commenting.FunctionComment.Missing

use Prodigi\LivewireCalendar\LivewireCalendar;

final class WithBusinessHoursTestCalendar extends LivewireCalendar {

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

describe('businessHours', function () {

    it('defaults to an empty array', function () {
        $calendar = new WithBusinessHoursTestCalendar;

        expect($calendar->businessHours())->toBe([]);
    });

    it('returns the value set via setBusinessHours()', function () {
        $hours    = [['daysOfWeek' => [1, 2, 3], 'startTime' => '09:00', 'endTime' => '17:00']];
        $calendar = new WithBusinessHoursTestCalendar;
        $calendar->setBusinessHours($hours);

        expect($calendar->businessHours())->toBe($hours);
    });

    it('reverts to empty array when called with no argument', function () {
        $hours    = [['daysOfWeek' => [1], 'startTime' => '08:00', 'endTime' => '16:00']];
        $calendar = (new WithBusinessHoursTestCalendar)
            ->setBusinessHours($hours)
            ->setBusinessHours();

        expect($calendar->businessHours())->toBe([]);
    });

    it('returns static for method chaining', function () {
        $calendar = new WithBusinessHoursTestCalendar;

        expect($calendar->setBusinessHours([]))->toBe($calendar);
    });
});
