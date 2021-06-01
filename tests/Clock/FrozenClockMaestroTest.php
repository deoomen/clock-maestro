<?php

declare(strict_types=1);

namespace ClockMaestro\Tests;

use ClockMaestro\Clock\FrozenClockMaestro;
use DateTimeZone;
use PHPUnit\Framework\TestCase;

class FrozenClockMaestroTest extends TestCase
{
    public function testFromSystemTimezone()
    {
        $timezoneBackup = date_default_timezone_get();
        $timezoneName = 'Europe/Warsaw';
        $timezone = new DateTimeZone($timezoneName);
        date_default_timezone_set($timezoneName);
        $clock = FrozenClockMaestro::fromSystemTimezone();

        $now = $clock->now();

        $this->assertEquals($timezone, $now->getTimezone());
        date_default_timezone_set($timezoneBackup);
    }

    public function testFromUTC()
    {
        $timezone = new DateTimeZone('UTC');
        $clock = FrozenClockMaestro::fromUTC();

        $now = $clock->now();

        $this->assertEquals($timezone, $now->getTimezone());
    }

    public function testFromTimezone()
    {
        $timezone = new DateTimeZone('Mexico/General');
        $clock = FrozenClockMaestro::fromTimezone($timezone);

        $now = $clock->now();

        $this->assertEquals($timezone, $now->getTimezone());
    }

    public function testNowIsFrozen()
    {
        $clock = FrozenClockMaestro::fromTimezone(new DateTimeZone('Europe/Warsaw'));

        $before = $clock->now();
        sleep(1);
        $after = $clock->now();

        $this->assertEquals($before, $after);
    }

    public function testToString()
    {
        $time = '2021-05-13T12:35:00UTC';
        $clock = FrozenClockMaestro::fromUTC($time);

        $this->assertSame($time, $clock->toString());
        $this->assertSame($time, (string) $clock);
    }

    public function testConvertTimezone(): void
    {
        $timestamp = "2021-05-27 12:00:00 Europe/Warsaw";
        $clock = FrozenClockMaestro::fromString($timestamp);

        $clock->convertTimezone(new DateTimeZone('UTC'));

        $this->assertEquals('UTC', $clock->now()->getTimezone()->getName());
    }

    public function testTimeCorrectConvertTimezone(): void
    {
        $timestamp = "2021-05-27 12:00:00 UTC";
        $clock = FrozenClockMaestro::fromString($timestamp);

        $clock->convertTimezone(new DateTimeZone('GMT+1'));

        $this->assertEquals('2021-05-27 13:00:00', $clock->now()->format('Y-m-d H:i:s'));
    }
}
