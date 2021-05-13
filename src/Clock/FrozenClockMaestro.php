<?php

declare(strict_types=1);

namespace ClockMaestro\Clock;

use ClockMaestro\ClockMaestroInterface;
use ClockMaestro\Exception\InvalidTimeZoneException;
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

    public function setTo(DateTimeImmutable $now): void
    {
        if ($now->getTimezone()->getName() !== $this->now->getTimezone()->getName()) {
            throw new InvalidTimeZoneException(
                sprintf(
                    'Given time is in "%s" timezone but current clock is in "%s" timezone.',
                    $now->getTimezone()->getName(),
                    $this->now->getTimezone()->getName()
                )
            );
        }

        $this->now = $now;
    }
}
