<?php

// phpcs:disable PEAR.Commenting.FunctionComment.Missing

use Prodigi\LivewireCalendar\LivewireCalendar;

final class WithEventDisplayTestCalendar extends LivewireCalendar {

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

describe('displayEventEnd', function () {

    it('defaults to true', function () {
        expect((new WithEventDisplayTestCalendar)->displayEventEnd())->toBeTrue();
    });

    it('can be set to false', function () {
        expect((new WithEventDisplayTestCalendar)->setDisplayEventEnd(false)->displayEventEnd())->toBeFalse();
    });

    it('can be set to true explicitly', function () {
        expect((new WithEventDisplayTestCalendar)->setDisplayEventEnd(true)->displayEventEnd())->toBeTrue();
    });

    it('reverts to true when called with no argument', function () {
        expect(
            (new WithEventDisplayTestCalendar)->setDisplayEventEnd(false)->setDisplayEventEnd()->displayEventEnd(),
        )->toBeTrue();
    });

    it('returns static for chaining', function () {
        $cal = new WithEventDisplayTestCalendar;
        expect($cal->setDisplayEventEnd(false))->toBe($cal);
    });
});

describe('displayEventTime', function () {

    it('defaults to true', function () {
        expect((new WithEventDisplayTestCalendar)->displayEventTime())->toBeTrue();
    });

    it('can be set to false', function () {
        expect((new WithEventDisplayTestCalendar)->setDisplayEventTime(false)->displayEventTime())->toBeFalse();
    });

    it('can be set to true explicitly', function () {
        expect((new WithEventDisplayTestCalendar)->setDisplayEventTime(true)->displayEventTime())->toBeTrue();
    });

    it('reverts to true when called with no argument', function () {
        expect(
            (new WithEventDisplayTestCalendar)->setDisplayEventTime(false)->setDisplayEventTime()->displayEventTime(),
        )->toBeTrue();
    });

    it('returns static for chaining', function () {
        $cal = new WithEventDisplayTestCalendar;
        expect($cal->setDisplayEventTime(false))->toBe($cal);
    });
});
