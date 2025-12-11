<?php

namespace Prodigi\LivewireCalendar\Concerns;

trait WithEventDisplay
{
    protected bool $displayEventEnd = true;

    protected bool $displayEventTime = true;

    public function displayEventEnd(): bool
    {
        return $this->displayEventEnd;
    }

    public function setDisplayEventEnd($displayEventEnd = true): static
    {
        $this->displayEventEnd = $displayEventEnd;

        return $this;
    }

    public function displayEventTime(): bool
    {
        return $this->displayEventTime;
    }

    public function setDisplayEventTime($displayEventTime = true): static
    {
        $this->displayEventTime = $displayEventTime;

        return $this;
    }
}
