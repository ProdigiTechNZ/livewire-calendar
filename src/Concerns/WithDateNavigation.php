<?php

namespace Prodigi\LivewireCalendar\Concerns;

use Carbon\Carbon;

/**
 * primary ref: https://fullcalendar.io/docs/date-navigation
 *
 * original author didn't bother with function comments
 *
 * phpcs:disable PEAR.Commenting.FunctionComment.Missing
 */
trait WithDateNavigation {

    protected ?Carbon $initialDate = null;

    public function initialDate(): string {

        if (is_null($this->initialDate)) {
            return Carbon::now();
        }

        return $this->initialDate;

    } //end initialDate()

    public function setInitialDate(?Carbon $initialDate=null): static {

        $this->initialDate = $initialDate;

        return $this;

    } //end setInitialDate()

}
