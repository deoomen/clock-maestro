<?php

declare(strict_types=1);

namespace ClockMaestro\Clock;

use ClockMaestro\ClockMaestroInterface;
use DateTimeImmutable;
use DateTimeZone;

class SystemClockMaestro implements ClockMaestroInterface
{
    private DateTimeZone $timezone;

    private function __construct(DateTimeZone $timezone)
    {
        $this->timezone = $timezone;
    }

    public static function fromTimezone(DateTimeZone $timezone): self
    {
        return new self($timezone);
    }

    public static function fromSystemTimezone(): self
    {
        return self::fromTimezone(new DateTimeZone(date_default_timezone_get()));
    }

    public static function fromUTC(): self
    {
        return self::fromTimezone(new DateTimeZone('UTC'));
    }

    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable('now', $this->timezone);
    }

    public function toString(string $format = DateTimeImmutable::ATOM): string
    {
        return $this->now()->format($format);
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
