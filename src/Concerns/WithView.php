<?php

namespace Prodigi\LivewireCalendar\Concerns;

trait WithView
{
    protected string $initialView = 'dayGridMonth';

    public function initialView(): string
    {
        return $this->initialView;
    }

    public function setInitialView($initialView = 'dayGridMonth'): static
    {
        $this->initialView = $initialView;

        return $this;
    }
}
