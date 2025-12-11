<?php

namespace Prodigi\LivewireCalendar\Concerns;

trait WithNow
{
    protected bool $now = true;

    protected bool $nowIndicator = false;

    public function now(): bool
    {
        return $this->now;
    }

    public function showNow(bool $now = true): static
    {
        $this->now = $now;

        return $this;
    }

    public function nowIndicator(): bool
    {
        return $this->nowIndicator;
    }

    public function showNowIndicator(bool $nowIndicator = true): static
    {
        $this->nowIndicator = $nowIndicator;

        return $this;
    }
}
