<?php

declare(strict_types=1);

namespace ClockMaestro;

use DateTimeImmutable;
use DateTimeZone;

interface ClockMaestro
{
    // public static function fromTimezone(DateTimeZone $timezone): self;

    // public static function fromSystemTimezone(): self;

    // public static function fromUTC(): self;

    public function now(): DateTimeImmutable;
}
