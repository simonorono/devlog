<?php

use Carbon\Carbon;
use Simonorono\Devlog\Data\Entry;
use Simonorono\Devlog\Data\EntryType;

test('can be serialized and un-serialized', function () {
    $entry = new Entry(Carbon::now(), EntryType::Log, 'test');

    /** @var Entry $newEntry */
    $newEntry = unserialize(serialize($entry));

    expect($newEntry)->toBeInstanceOf(Entry::class)
        ->and($newEntry->type)
        ->toBeInstanceOf(EntryType::class)
        ->toBe(EntryType::Log)
        ->and($newEntry->content)
        ->toBeString()
        ->toBe('test');
});
