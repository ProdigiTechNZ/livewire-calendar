# A Livewire wrapper for FullCalendar.

Livewire Calendar is an easy way to make use of [FullCalendar](https://fullcalendar.io/) in your Laravel applications.

Forked from [ACTTraining/livewire-calendar](https://github.com/ACTTraining/livewire-calendar). However, this appears to be abandonware, so it has been heavily tweaked (and internally renamed, so it's less likely to collide with the original)

## Installation

You can install the package via composer:

```bash
composer require prodigi/livewire-calendar
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="livewire-calendar-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="livewire-calendar-views"
```

## Usage

```php
$livewireCalendar = new Prodigi\LivewireCalendar();
echo $livewireCalendar->echoPhrase('Hello!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Originally Authored Be

- [Simon Barrett](https://github.com/SimonBarrettACT)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
