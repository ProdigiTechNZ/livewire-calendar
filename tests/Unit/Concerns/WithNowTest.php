<?php

// phpcs:disable PEAR.Commenting.FunctionComment.Missing

use Prodigi\LivewireCalendar\LivewireCalendar;

final class WithNowTestCalendar extends LivewireCalendar {

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

describe('now', function () {

    it('defaults to true', function () {
        expect((new WithNowTestCalendar)->now())->toBeTrue();
    });

    it('can be set to false', function () {
        expect((new WithNowTestCalendar)->showNow(false)->now())->toBeFalse();
    });

    it('can be set to true explicitly', function () {
        expect((new WithNowTestCalendar)->showNow(true)->now())->toBeTrue();
    });

    it('reverts to true when called with no argument', function () {
        expect((new WithNowTestCalendar)->showNow(false)->showNow()->now())->toBeTrue();
    });

    it('returns static for chaining', function () {
        $cal = new WithNowTestCalendar;
        expect($cal->showNow(false))->toBe($cal);
    });
});

describe('nowIndicator', function () {

    it('defaults to false', function () {
        expect((new WithNowTestCalendar)->nowIndicator())->toBeFalse();
    });

    it('can be set to true', function () {
        expect((new WithNowTestCalendar)->showNowIndicator(true)->nowIndicator())->toBeTrue();
    });

    it('can be set to false explicitly', function () {
        expect((new WithNowTestCalendar)->showNowIndicator(false)->nowIndicator())->toBeFalse();
    });

    it('reverts to true when called with no argument', function () {
        expect((new WithNowTestCalendar)->showNowIndicator()->nowIndicator())->toBeTrue();
    });

    it('returns static for chaining', function () {
        $cal = new WithNowTestCalendar;
        expect($cal->showNowIndicator(true))->toBe($cal);
    });
});
