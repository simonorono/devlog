<?php

use Carbon\Carbon;
use Simonorono\Devlog\Data\Entry;
use Simonorono\Devlog\Data\EntryType;
use Simonorono\Devlog\Storage\FileStorage;
use Simonorono\Devlog\Storage\StorageException;

describe('file storage tests', function () {
    function cleanUp(): void
    {
        $dir = sys_get_temp_dir().DIRECTORY_SEPARATOR.FileStorage::DATA_DIR;
        system("rm -rf $dir");
    }

    function dataDir(): string
    {
        return sys_get_temp_dir().DIRECTORY_SEPARATOR.FileStorage::DATA_DIR;
    }

    function filename(): string
    {
        return dataDir().DIRECTORY_SEPARATOR.FileStorage::FILENAME;
    }

    beforeEach(fn () => cleanUp());

    afterEach(fn () => cleanUp());

    it('can be initialized', function () {
        new FileStorage(sys_get_temp_dir());
    })->throwsNoExceptions();

    it('will throw exception due to bad file', function () {
        mkdir(dataDir(), 0700, true);

        touch(filename());

        file_put_contents(filename(), 'bad data');

        new FileStorage(sys_get_temp_dir());
    })->throws(StorageException::class);

    it('will throw an exception due to base dir being a file', function () {
        $file = tmpfile();

        new FileStorage(stream_get_meta_data($file)['uri']);
    })->throws(StorageException::class);

    test('returns empty array after initialization', function () {
        $storage = new FileStorage(sys_get_temp_dir());

        expect($storage->allEntries())->toBe([]);
    });

    test('creates entry', function () {
        $storage = new FileStorage(sys_get_temp_dir());

        $entry = new Entry(Carbon::now(), EntryType::Log, 'test');

        $storage->addEntry($entry);

        $entries = $storage->allEntries();

        expect($entries)
            ->toBeArray()
            ->toHaveLength(1)
            ->and($entries[0])
            ->toEqual($entry);
    });

    test('deletes entry', function () {
        $storage = new FileStorage(sys_get_temp_dir());

        $entry = new Entry(Carbon::now(), EntryType::Log, 'test');

        $storage->addEntry($entry);

        $entries = $storage->allEntries();

        expect($entries)
            ->toBeArray()
            ->toHaveLength(1)
            ->and($entries[0])
            ->toEqual($entry);

        $storage->deleteEntry($entry);

        expect($storage->allEntries())
            ->toBeArray()
            ->toHaveLength(0);
    });
});
