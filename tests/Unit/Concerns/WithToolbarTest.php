<?php

// phpcs:disable PEAR.Commenting.FunctionComment.Missing

use Prodigi\LivewireCalendar\LivewireCalendar;

final class WithToolbarTestCalendar extends LivewireCalendar {

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

describe('headerToolbar', function () {

    it('defaults to null', function () {
        expect((new WithToolbarTestCalendar)->headerToolbar())->toBeNull();
    });

    it('returns the array set via setHeaderToolbar()', function () {
        $toolbar = ['left' => 'prev,next', 'center' => 'title', 'right' => 'dayGridMonth'];
        expect((new WithToolbarTestCalendar)->setHeaderToolbar($toolbar)->headerToolbar())->toBe($toolbar);
    });

    it('can be explicitly set to null', function () {
        $toolbar = ['left' => 'prev'];
        expect(
            (new WithToolbarTestCalendar)->setHeaderToolbar($toolbar)->setHeaderToolbar(null)->headerToolbar(),
        )->toBeNull();
    });

    it('reverts to null when called with no argument', function () {
        $toolbar = ['left' => 'prev'];
        expect(
            (new WithToolbarTestCalendar)->setHeaderToolbar($toolbar)->setHeaderToolbar()->headerToolbar(),
        )->toBeNull();
    });

    it('returns static for chaining', function () {
        $cal = new WithToolbarTestCalendar;
        expect($cal->setHeaderToolbar(null))->toBe($cal);
    });
});

describe('footerToolbar', function () {

    it('defaults to null', function () {
        expect((new WithToolbarTestCalendar)->footerToolbar())->toBeNull();
    });

    it('returns the array set via setFooterToolbar()', function () {
        $toolbar = ['left' => 'prev,next', 'center' => 'title', 'right' => 'dayGridMonth'];
        expect((new WithToolbarTestCalendar)->setFooterToolbar($toolbar)->footerToolbar())->toBe($toolbar);
    });

    it('can be explicitly set to null', function () {
        $toolbar = ['left' => 'prev'];
        expect(
            (new WithToolbarTestCalendar)->setFooterToolbar($toolbar)->setFooterToolbar(null)->footerToolbar(),
        )->toBeNull();
    });

    it('reverts to null when called with no argument', function () {
        $toolbar = ['left' => 'prev'];
        expect(
            (new WithToolbarTestCalendar)->setFooterToolbar($toolbar)->setFooterToolbar()->footerToolbar(),
        )->toBeNull();
    });

    it('returns static for chaining', function () {
        $cal = new WithToolbarTestCalendar;
        expect($cal->setFooterToolbar(null))->toBe($cal);
    });
});
