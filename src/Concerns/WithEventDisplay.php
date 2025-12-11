<?php

namespace Prodigi\LivewireCalendar\Concerns;

/**
 * primary ref: https://fullcalendar.io/docs/event-display
 *
 * original author didn't bother with function comments
 *
 * phpcs:disable PEAR.Commenting.FunctionComment.Missing
 */
trait WithEventDisplay {

    protected bool $displayEventEnd = true;

    protected bool $displayEventTime = true;

    public function displayEventEnd(): bool {

        return $this->displayEventEnd;

    } //end displayEventEnd()

    public function setDisplayEventEnd(bool $displayEventEnd=true): static {

        $this->displayEventEnd = $displayEventEnd;

        return $this;

    } //end setDisplayEventEnd()

    public function displayEventTime(): bool {

        return $this->displayEventTime;

    } //end displayEventTime()

    public function setDisplayEventTime(bool $displayEventTime=true): static {

        $this->displayEventTime = $displayEventTime;

        return $this;

    } //end setDisplayEventTime()

}
