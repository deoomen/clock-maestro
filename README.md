# Clock Maestro

Single source of truth about time and date in your PHP application.

## Installation

Use composer to install Clock Maestro into your project:

```
composer require deoomen/clock-maestro
```

## How to use

### Frozen clock

It always returns the same value - the time when it was initiated.

```php
<?php

use ClockMaestro\Clock\FrozenClockMaestro;

// ...

// Use system default timezone
$clock = FrozenClockMaestro::fromSystemTimezone();
$now = $clock->now();

// Use UTC timezone
$clock = FrozenClockMaestro::fromUTC();
$now = $clock->now();

// Use given timezone
$timezone = new DateTimeZone('Mexico/General');
$clock = FrozenClockMaestro::fromTimezone($timezone);
$now = $clock->now();

// Get time as string with default format: `Y-m-d\TH:i:sP` - (ATOM, compatible with ISO-8601 format)
$clock = FrozenClockMaestro::fromUTC();
$nowAsString = $clock->toString();  // ex. 2021-05-13T12:30:00+00:00

// Get time as string with custom foramt
$clock = FrozenClockMaestro::fromUTC();
$nowAsString = $clock->toString('d.m.Y H:i');  // ex. 13.05.2021 12:30
```

### System clock

Returns the current time.

```php
<?php

use ClockMaestro\Clock\SystemClockMaestro;

// ...

// Use system default timezone
$clock = SystemClockMaestro::fromSystemTimezone();
$now = $clock->now();

// Use UTC timezone
$clock = SystemClockMaestro::fromUTC();
$now = $clock->now();

// Use given timezone
$timezone = new DateTimeZone('Mexico/General');
$clock = SystemClockMaestro::fromTimezone($timezone);
$now = $clock->now();

// Get time as string with default format: `Y-m-d\TH:i:sP` - (ATOM, compatible with ISO-8601 format)
$clock = SystemClockMaestro::fromUTC();
$nowAsString = $clock->toString();  // ex. 2021-05-13T12:30:00+00:00

// Get time as string with custom foramt
$clock = SystemClockMaestro::fromUTC();
$nowAsString = $clock->toString('d.m.Y H:i');  // ex. 13.05.2021 12:30
```

## License

[MIT License](./LICENSE)
