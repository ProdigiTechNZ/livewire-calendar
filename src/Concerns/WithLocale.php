<?php

namespace Prodigi\LivewireCalendar\Concerns;

/**
 * primary ref: https://fullcalendar.io/docs/locale
 *              https://fullcalendar.io/docs/timeZone
 *
 * original author didn't bother with function comments
 *
 * phpcs:disable PEAR.Commenting.FunctionComment.Missing
 */
trait WithLocale {

    protected ?string $locale = null;

    protected ?string $timeZone = null;

    protected int $firstDay = 0;

    public function locale(): string {

        if (is_null($this->locale)) {
            return config('app.locale');
        }

        return $this->locale;

    } //end locale()

    public function timeZone(): string {

        if (is_null($this->timeZone)) {
            return config('app.timezone');
        }

        return $this->timeZone;

    } //end timeZone()

    public function setTimeZone(string $timeZone='local'): static {

        $this->timeZone = $timeZone;

        return $this;

    } //end setTimeZone()

    public function setLocale(string $locale='en'): static {

        $this->locale = $locale;

        return $this;

    } //end setLocale()

    public function firstDay(): int {

        return $this->firstDay;

    } //end firstDay()

    public function setFirstDay(int $firstDay): static {

        $this->firstDay = $firstDay;

        return $this;

    } //end setFirstDay()

}
