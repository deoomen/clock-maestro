<?php

declare(strict_types=1);

namespace ClockMaestro;

use DateTimeImmutable;
use DateTimeZone;

interface ClockMaestroInterface
{
    public function now(): DateTimeImmutable;

    public function convertTimezone(DateTimeZone $timezone): void;

    public function toString(string $format = DateTimeImmutable::ATOM): string;

    public function __toString(): string;
}
