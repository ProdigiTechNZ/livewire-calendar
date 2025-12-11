<?php

namespace Prodigi\LivewireCalendar\Concerns;

/**
 * primary reference: https://fullcalendar.io/docs/businessHours
 *
 * original author didn't bother with function comments
 *
 * phpcs:disable PEAR.Commenting.FunctionComment.Missing
 */
trait WithBusinessHours {

    /** @var array<mixed> $businessHours */
    protected array $businessHours = [];

    /**
     * (default=false)
     * ref: https://fullcalendar.io/docs/businessHours
     *
     * @return array<mixed>
     */
    public function businessHours(): array {

        return $this->businessHours;

    } //end businessHours()

    /**
     * (default=false)
     * ref: https://fullcalendar.io/docs/businessHours
     *
     * @param array<mixed> $businessHours
     */
    public function setBusinessHours(array $businessHours=[]): static {

        $this->businessHours = $businessHours;

        return $this;

    } //end setBusinessHours()

}
