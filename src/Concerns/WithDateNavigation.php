<?php

namespace Prodigi\LivewireCalendar\Concerns;

use Carbon\Carbon;

trait WithDateNavigation {

    protected ?Carbon $initialDate = null;

    public function initialDate(): string {

        if (is_null($this->initialDate)) {
            return Carbon::now();
        }

        return $this->initialDate;

    } //end initialDate()

    public function setInitialDate($initialDate=null): static {

        $this->initialDate = $initialDate;

        return $this;

    } //end setInitialDate()

}
