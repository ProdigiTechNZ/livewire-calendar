<?php

namespace Prodigi\LivewireCalendar\Concerns;

/**
 * primary reference: https://fullcalendar.io/docs/initialView
 *
 * original author didn't bother with function comments
 *
 * phpcs:disable PEAR.Commenting.FunctionComment.Missing
 */
trait WithView {

    protected string $initialView = 'dayGridMonth';

    public function initialView(): string {

        return $this->initialView;

    } //end initialView()

    /**
     * A name of any of the available views, such as 'dayGridWeek', 'timeGridDay', 'listWeek' .
     *
     * ref: https://fullcalendar.io/docs/initialView
     */
    public function setInitialView(string $initialView='dayGridMonth'): static {

        $this->initialView = $initialView;

        return $this;

    } //end setInitialView()

}
