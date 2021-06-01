<?php

declare(strict_types=1);

namespace ClockMaestro;

use DateTimeImmutable;
use DateTimeZone;

interface ClockMaestroInterface
{
    public const DEFAULT_FORMAT = 'Y-m-d\TH:i:se';

    public function now(): DateTimeImmutable;

    public function convertTimezone(DateTimeZone $timezone): void;

    public function toString(string $format = self::DEFAULT_FORMAT): string;

    public function __toString(): string;
}
