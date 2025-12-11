<?php

namespace Prodigi\LivewireCalendar\Concerns;

trait WithDateAndTime {

    protected bool $showWeekends = true;

    protected string $slotDuration = '00:30:00';

    protected bool $showNonCurrentDates = true;

    protected bool $fixedWeekCount = true;

    protected string $slotMinTime = '00:00:00';

    protected string $slotMaxTime = '24:00:00';

    public function weekends(): bool {

        return $this->showWeekends;

    } //end weekends()

    public function showWeekends(bool $showWeekends=true): static {

        $this->showWeekends = $showWeekends;

        return $this;

    } //end showWeekends()

    public function slotDuration(): string {

        return $this->slotDuration;

    } //end slotDuration()

    public function setSlotDuration(string $slotDuration): static {

        $this->slotDuration = $slotDuration;

        return $this;

    } //end setSlotDuration()

    public function showNonCurrentDates(): bool {

        return $this->showNonCurrentDates;

    } //end showNonCurrentDates()

    public function shouldShowNonCurrentDates(bool $showNonCurrentDates): static {

        $this->showNonCurrentDates = $showNonCurrentDates;

        return $this;

    } //end shouldShowNonCurrentDates()

    public function fixedWeekCount(): bool {

        return $this->fixedWeekCount;

    } //end fixedWeekCount()

    public function setFixedWeekCount(bool $fixedWeekCount): static {

        $this->fixedWeekCount = $fixedWeekCount;

        return $this;

    } //end setFixedWeekCount()

    public function slotMinTime(): string {

        return $this->slotMinTime;

    } //end slotMinTime()

    public function setSlotMinTime(string $slotMinTime): static {

        $this->slotMinTime = $slotMinTime;

        return $this;

    } //end setSlotMinTime()

    public function slotMaxTime(): string {

        return $this->slotMaxTime;

    } //end slotMaxTime()

    public function setSlotMaxTime(string $slotMaxTime): static {

        $this->slotMaxTime = $slotMaxTime;

        return $this;

    } //end setSlotMaxTime()

}
