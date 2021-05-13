<?php

declare(strict_types=1);

namespace ClockMaestro;

use DateTimeImmutable;
use DateTimeZone;

interface ClockMaestroInterface
{
    public function now(): DateTimeImmutable;
}
