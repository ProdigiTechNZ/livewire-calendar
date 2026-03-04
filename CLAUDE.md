# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What This Is

A Laravel package (`prodigi/livewire-calendar`) that wraps [FullCalendar](https://fullcalendar.io/) as a Livewire v3 component. Forked from ACTTraining/livewire-calendar. Uses [spatie/laravel-package-tools](https://github.com/spatie/laravel-package-tools) for package boilerplate.

## Commands

```bash
# Run tests
composer test

# Run tests with coverage
composer test-coverage

# Static analysis
composer analyse
# or: vendor/bin/phpstan analyse --no-progress --memory-limit 512M -c ./phpstan.neon

# Code formatting (Pint)
composer format

# Build workbench (testbench dev app)
composer build

# Serve workbench dev app
composer start
```

## Architecture

**`src/LivewireCalendar.php`** — Abstract base Livewire component. Consumers extend this class and implement:
- `getEventsProperty(): array` — computed property providing events to FullCalendar
- `eventClick(array $info): void` — handles JS event clicks passed via `@this.eventClick`

Calls `config()` on `booted()` — override `config()` to fluently set calendar options using the `set*` methods from traits.

**`src/Concerns/`** — Eight traits composing the calendar behaviour, each mapping to a FullCalendar docs section:
- `WithView` — `initialView` (dayGridMonth default)
- `WithDateNavigation` — `initialDate`
- `WithDateAndTime` — weekends, slot duration/min/max, non-current dates, fixed week count
- `WithEventDisplay` — displayEventEnd, displayEventTime
- `WithLocale` — locale, timezone (defaults from `config('app.*')`), firstDay
- `WithNow` — nowIndicator
- `WithToolbar` — headerToolbar, footerToolbar (null = FullCalendar default)
- `WithBusinessHours` — businessHours array

**`resources/views/calendar.blade.php`** — Single blade view. Uses Alpine.js with `wire:ignore` to initialise FullCalendar. Events are passed as `@js($this->events)`. All trait options are wired via `@js($this->methodName())`.

**`src/LivewireCalendarServiceProvider.php`** — Registers config (`livewire-calendar.php`), views, and a `@livewireCalendarScript` Blade directive that injects the FullCalendar CDN script tag.

**`workbench/`** — Testbench-driven development app (via `orchestra/testbench`). Run `composer start` to serve it locally.

## Testing

Tests live in `tests/` and use Pest with `pestphp/pest-plugin-livewire`. The workbench app namespace is `Workbench\App\`.

```bash
# Run all tests
composer test

# Filter to a specific test
vendor/bin/pest --filter="test name"

# coverage
p-test cl-livewire-calendar --cov-claude <TestName>
```

## Key Constraints

- PHP ^8.3, Livewire ^3.6.4
- FullCalendar loaded via CDN (v6.1.10) using `@livewireCalendarScript` directive — no npm build step
- The config file (`config/livewire-calendar.php`) is intentionally empty; all configuration is done via fluent `set*` methods in `config()` override
- `Carbon` is used in `WithDateNavigation` (not Chronos) — keep consistent with existing trait

# BOOST MCP

- Use `laravel-boost` server (built for this app)
- Before artisan commands: check `list-artisan-commands`
- URLs: use `get-absolute-url` tool
- Debugging: use `tinker` for PHP, `database-query` for reads, `database-schema` for structure
- Browser logs: use `browser-logs` tool (ignore old entries)
- **Search docs BEFORE coding:** use `search-docs` with broad, topic-based queries
  - Examples: `['rate limiting', 'routing']` not `['Laravel 12 rate limiting']`
