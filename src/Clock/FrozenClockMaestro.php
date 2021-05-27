<?php

declare(strict_types=1);

namespace ClockMaestro\Clock;

use ClockMaestro\ClockMaestroInterface;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;

class FrozenClockMaestro implements ClockMaestroInterface
{
    private DateTimeImmutable $now;

    private function __construct(DateTimeImmutable $now)
    {
        $this->now = $now;
    }

    public static function fromTimezone(DateTimeZone $timezone, string $time = 'now'): self
    {
        return new self(new DateTimeImmutable($time, $timezone));
    }

    public static function fromSystemTimezone(string $time = 'now'): self
    {
        return self::fromTimezone(new DateTimeZone(date_default_timezone_get()), $time);
    }

    public static function fromUTC(string $time = 'now'): self
    {
        return self::fromTimezone(new DateTimeZone('UTC'), $time);
    }

    public function now(): DateTimeImmutable
    {
        return $this->now;
    }

    public function convertTimezone(DateTimeZone $timezone): void
    {
        $this->now = DateTimeImmutable::createFromMutable(DateTime::createFromImmutable($this->now)->setTimezone($timezone));
    }

    public function toString(string $format = DateTimeImmutable::ATOM): string
    {
        return $this->now->format($format);
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
