<?php

namespace Simonorono\Devlog\Storage;

use Simonorono\Devlog\Data\Entry;

class FileStorage
{
    const DATA_DIR = 'com.simonorono.devlog';

    const FILENAME = 'log.dat';

    protected string $baseDir;

    /**
     * @throws StorageException
     */
    public function __construct(string $baseDir = null)
    {
        $this->baseDir = is_null($baseDir)
            ? $_SERVER['HOME'].DIRECTORY_SEPARATOR.'.config'
            : $baseDir;

        if (! is_dir($this->baseDir)) {
            throw new StorageException("Not a directory. Check that $this->baseDir is a directory.");
        }

        if (file_exists($filename = $this->getFilename())) {
            try {
                $content = file_get_contents($filename);

                if (unserialize($content) === false) {
                    throw new \Exception('bad format');
                }
            } catch (\Throwable $t) {
                throw new StorageException("Error reading file: {$t->getMessage()}");
            }
        } else {
            mkdir($this->baseDir.DIRECTORY_SEPARATOR.self::DATA_DIR, 0711, true);

            touch($this->getFilename());

            file_put_contents($filename, serialize([]));
        }
    }

    public function getDataDir(): string
    {
        return $this->baseDir.DIRECTORY_SEPARATOR.self::DATA_DIR;
    }

    public function getFilename(): string
    {
        return $this->getDatadir().DIRECTORY_SEPARATOR.self::FILENAME;
    }

    private function write(array $entries): void
    {
        file_put_contents($this->getFilename(), serialize($entries));
    }

    public function addEntry(Entry $entry): void
    {
        $entries = $this->allEntries();

        $entries[] = $entry;

        $this->write($entries);
    }

    public function allEntries(): array
    {
        $textContent = file_get_contents($this->getFilename());

        $entries = unserialize($textContent);

        usort($entries, fn (Entry $e1, Entry $e2) => $e1->compare($e2));

        return $entries;
    }

    public function deleteEntry(Entry $entry): void
    {
        $entries = $this->allEntries();

        $entries = array_filter($entries, fn ($e) => $e != $entry);

        $this->write($entries);
    }
}
