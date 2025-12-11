<?php

namespace Prodigi\LivewireCalendar\Concerns;

trait WithToolbar {

    protected ?array $headerToolbar = null;

    protected ?array $footerToolbar = null;

    public function headerToolbar(): ?array {

        return $this->headerToolbar;

    } //end headerToolbar()

    public function setHeaderToolbar($headerToolbar=null): static {

        $this->headerToolbar = $headerToolbar;

        return $this;

    } //end setHeaderToolbar()

    public function footerToolbar(): ?array {

        return $this->footerToolbar;

    } //end footerToolbar()

    public function setFooterToolbar($footerToolbar=null): static {

        $this->footerToolbar = $footerToolbar;

        return $this;

    } //end setFooterToolbar()

}
