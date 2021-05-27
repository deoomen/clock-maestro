<?php

declare(strict_types=1);

namespace ClockMaestro\Tests;

use ClockMaestro\Clock\SystemClockMaestro;
use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\TestCase;

class SystemClockMaestroTest extends TestCase
{
    public function testFromSystemTimezone()
    {
        $timezoneBackup = date_default_timezone_get();
        $timezoneName = 'Europe/Warsaw';
        $timezone = new DateTimeZone($timezoneName);
        date_default_timezone_set($timezoneName);
        $clock = SystemClockMaestro::fromSystemTimezone();

        $now = $clock->now();

        $this->assertEquals($timezone, $now->getTimezone());
        date_default_timezone_set($timezoneBackup);
    }

    public function testFromUTC()
    {
        $timezone = new DateTimeZone('UTC');
        $clock = SystemClockMaestro::fromUTC();

        $now = $clock->now();

        $this->assertEquals($timezone, $now->getTimezone());
    }

    public function testFromTimezone()
    {
        $timezone = new DateTimeZone('Mexico/General');
        $clock = SystemClockMaestro::fromTimezone($timezone);

        $now = $clock->now();

        $this->assertEquals($timezone, $now->getTimezone());
    }

    public function testNowIsTicking()
    {
        $timezone = new DateTimeZone('Europe/Warsaw');
        $clock = SystemClockMaestro::fromTimezone($timezone);

        $before = new DateTimeImmutable('now', $timezone);
        $now = $clock->now();
        $after = new DateTimeImmutable('now', $timezone);
        sleep(1);
        $afterAfter = $clock->now();

        $this->assertGreaterThanOrEqual($before, $now);
        $this->assertLessThanOrEqual($after, $now);
        $this->assertLessThanOrEqual($afterAfter, $after);
    }

    public function testConvertTimezone(): void
    {
        $clock = SystemClockMaestro::fromTimezone(new DateTimeZone('Europe/Warsaw'));

        $clock->convertTimezone(new DateTimeZone('UTC'));

        $this->assertEquals('UTC', $clock->now()->getTimezone()->getName());
    }

    public function testTimeCorrectConvertTimezone(): void
    {
        $clock = SystemClockMaestro::fromTimezone(new DateTimeZone('UTC'));
        $before = $clock->toString('Y-m-d H:i');

        $clock->convertTimezone(new DateTimeZone('GMT+1'));
        $after = $clock->toString('Y-m-d H:i');

        $this->assertGreaterThan($before, $after);
    }
}
