<?php

namespace Prodigi\LivewireCalendar\Concerns;

trait WithBusinessHours
{
    protected array $businessHours = [];

    public function businessHours(): array
    {
        return $this->businessHours;
    }

    public function setBusinessHours($businessHours = []): static
    {
        $this->businessHours = $businessHours;

        return $this;
    }
}
