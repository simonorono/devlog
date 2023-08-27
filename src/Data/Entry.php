<?php

namespace Simonorono\Devlog\Data;

use Carbon\Carbon;

class Entry
{
    public function __construct(
        public Carbon $timestamp,
        public EntryType $type,
        public string $content,
    ) {
    }

    public function compare(Entry $another): int
    {
        return $this->timestamp->isBefore($another->timestamp) ? -1 : 1;
    }

    public function __toString(): string
    {
        $ts = (clone $this->timestamp);
        $ts->setTimezone('America/Caracas');
        $ts->toTimeString();

        return "[{$ts->toTimeString()}] $this->content";
    }
}
