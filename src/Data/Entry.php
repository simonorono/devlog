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
        return $this->timestamp->isAfter($another->timestamp) ? -1 : 1;
    }

    public function isMeeting(): bool
    {
        return $this->type == EntryType::Meeting;
    }

    public function __toString(): string
    {
        $str = "[{$this->timestamp->toTimeString()}]";

        if ($this->isMeeting()) {
            $str .= '[MEETING]';
        }

        return $str." $this->content";
    }
}
