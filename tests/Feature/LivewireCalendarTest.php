<?php

// phpcs:disable PEAR.Commenting.FunctionComment.Missing

use Livewire\Livewire;
use Prodigi\LivewireCalendar\LivewireCalendar;

// ---------------------------------------------------------------------------
// Fixtures — LivewireCalendar is abstract; these provide concrete targets
// ---------------------------------------------------------------------------

/** @SuppressWarnings("NumberOfPublicMethods") */
final class TestCalendar extends LivewireCalendar {

    /** @return array<mixed> */
    public function getEventsProperty(): array {

        return [['id' => 1, 'title' => 'Test Event']];

    } //end getEventsProperty()

    /**
     * @param array<mixed> $info
     *
     * @SuppressWarnings("UnusedFormalParameter")
     */
    public function eventClick(array $info): void {

        // no-op — required by abstract contract, not exercised in these tests

    } //end eventClick()

} //end class

/** Tracks whether config() is called during booted() */
final class ConfigTrackingCalendar extends LivewireCalendar {

    public bool $configCalled = false;

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

        // no-op — required by abstract contract, not exercised in these tests

    } //end eventClick()

    public function config(): void {

        $this->configCalled = true;

    } //end config()

} //end class

// ---------------------------------------------------------------------------
// Tests
// ---------------------------------------------------------------------------

describe('render', function () {

    it('renders the livewire-calendar::calendar view', function () {
        Livewire::test(TestCalendar::class)
            ->assertViewIs('livewire-calendar::calendar');
    });
});

describe('booted', function () {

    it('calls config() when the component boots', function () {
        $component = Livewire::test(ConfigTrackingCalendar::class);

        expect($component->instance()->configCalled)->toBeTrue();
    });
});

describe('config', function () {

    it('is a no-op by default and the component boots without error', function () {
        Livewire::test(TestCalendar::class)
            ->assertHasNoErrors();
    });
});
