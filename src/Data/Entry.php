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
}
