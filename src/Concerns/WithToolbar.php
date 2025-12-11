<?php

namespace Prodigi\LivewireCalendar\Concerns;

/**
 * primary reference: https://fullcalendar.io/docs/headerToolbar
 *
 * original author didn't bother with function comments
 *
 * phpcs:disable PEAR.Commenting.FunctionComment.Missing
 */
trait WithToolbar {

    /** @var array<mixed> $headerToolbar */
    protected ?array $headerToolbar = null;

    /** @var array<mixed> $footerToolbar */
    protected ?array $footerToolbar = null;

    /**
     * (default=false)
     * ref: https://fullcalendar.io/docs/headerToolbar
     *
     * @return ?array<mixed>
     */
    public function headerToolbar(): ?array {

        return $this->headerToolbar;

    } //end headerToolbar()

    /**
     * ref: https://fullcalendar.io/docs/headerToolbar
     *
     * @param ?array<mixed> $headerToolbar
     */
    public function setHeaderToolbar(?array $headerToolbar=null): static {

        $this->headerToolbar = $headerToolbar;

        return $this;

    } //end setHeaderToolbar()

    /**
     * uses same settings at the header (default=false)
     * ref: https://fullcalendar.io/docs/headerToolbar
     *
     * @return ?array<mixed>
     */
    public function footerToolbar(): ?array {

        return $this->footerToolbar;

    } //end footerToolbar()

    /**
     * uses same settings at the header (default=false)
     * ref: https://fullcalendar.io/docs/headerToolbar
     *
     * @param ?array<mixed> $footerToolbar
     */
    public function setFooterToolbar(?array $footerToolbar=null): static {

        $this->footerToolbar = $footerToolbar;

        return $this;

    } //end setFooterToolbar()

}
