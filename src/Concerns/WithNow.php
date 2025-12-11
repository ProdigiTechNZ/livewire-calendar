<?php

namespace Prodigi\LivewireCalendar\Concerns;

/**
 * primary reference: https://fullcalendar.io/docs/now-indicator
 *
 * original author didn't bother with function comments
 *
 * phpcs:disable PEAR.Commenting.FunctionComment.Missing
 */
trait WithNow {

    protected bool $now = true;

    protected bool $nowIndicator = false;

    public function now(): bool {

        return $this->now;

    } //end now()

    public function showNow(bool $now=true): static {

        $this->now = $now;

        return $this;

    } //end showNow()

    public function nowIndicator(): bool {

        return $this->nowIndicator;

    } //end nowIndicator()

    public function showNowIndicator(bool $nowIndicator=true): static {

        $this->nowIndicator = $nowIndicator;

        return $this;

    } //end showNowIndicator()

}
