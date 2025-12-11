<?php

namespace Prodigi\LivewireCalendar\Concerns;

trait WithEventDisplay {

    protected bool $displayEventEnd = true;

    protected bool $displayEventTime = true;

    public function displayEventEnd(): bool {

        return $this->displayEventEnd;

    } //end displayEventEnd()

    public function setDisplayEventEnd($displayEventEnd=true): static {

        $this->displayEventEnd = $displayEventEnd;

        return $this;

    } //end setDisplayEventEnd()

    public function displayEventTime(): bool {

        return $this->displayEventTime;

    } //end displayEventTime()

    public function setDisplayEventTime($displayEventTime=true): static {

        $this->displayEventTime = $displayEventTime;

        return $this;

    } //end setDisplayEventTime()

}
