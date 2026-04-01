<?php

// phpcs:disable PEAR.Commenting.FunctionComment.Missing

use Prodigi\LivewireCalendar\Tests\Support\ConcreteCalendar;

describe('headerToolbar', function () {

    it('defaults to null', function () {
        expect((new ConcreteCalendar)->headerToolbar())->toBeNull();
    });

    it('returns the array set via setHeaderToolbar()', function () {
        $toolbar = ['left' => 'prev,next', 'center' => 'title', 'right' => 'dayGridMonth'];
        expect((new ConcreteCalendar)->setHeaderToolbar($toolbar)->headerToolbar())->toBe($toolbar);
    });

    it('treats an empty array as a distinct value from null', function () {
        // FullCalendar: null = default toolbar; [] = no toolbar. These are semantically different.
        expect((new ConcreteCalendar)->setHeaderToolbar([])->headerToolbar())->toBe([]);
    });

    it('can be explicitly set to null', function () {
        $toolbar = ['left' => 'prev'];
        expect(
            (new ConcreteCalendar)->setHeaderToolbar($toolbar)->setHeaderToolbar(null)->headerToolbar(),
        )->toBeNull();
    });

    it('reverts to null when called with no argument', function () {
        $toolbar = ['left' => 'prev'];
        expect(
            (new ConcreteCalendar)->setHeaderToolbar($toolbar)->setHeaderToolbar()->headerToolbar(),
        )->toBeNull();
    });

    it('returns static for chaining', function () {
        $cal = new ConcreteCalendar;
        expect($cal->setHeaderToolbar(null))->toBe($cal);
    });
});

describe('footerToolbar', function () {

    it('defaults to null', function () {
        expect((new ConcreteCalendar)->footerToolbar())->toBeNull();
    });

    it('returns the array set via setFooterToolbar()', function () {
        $toolbar = ['left' => 'prev,next', 'center' => 'title', 'right' => 'dayGridMonth'];
        expect((new ConcreteCalendar)->setFooterToolbar($toolbar)->footerToolbar())->toBe($toolbar);
    });

    it('treats an empty array as a distinct value from null', function () {
        // FullCalendar: null = default toolbar; [] = no toolbar. These are semantically different.
        expect((new ConcreteCalendar)->setFooterToolbar([])->footerToolbar())->toBe([]);
    });

    it('can be explicitly set to null', function () {
        $toolbar = ['left' => 'prev'];
        expect(
            (new ConcreteCalendar)->setFooterToolbar($toolbar)->setFooterToolbar(null)->footerToolbar(),
        )->toBeNull();
    });

    it('reverts to null when called with no argument', function () {
        $toolbar = ['left' => 'prev'];
        expect(
            (new ConcreteCalendar)->setFooterToolbar($toolbar)->setFooterToolbar()->footerToolbar(),
        )->toBeNull();
    });

    it('returns static for chaining', function () {
        $cal = new ConcreteCalendar;
        expect($cal->setFooterToolbar(null))->toBe($cal);
    });
});
