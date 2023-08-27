<?php

namespace Simonorono\Devlog;

use Composer\InstalledVersions;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use PhpSchool\CliMenu\Exception\InvalidTerminalException;
use Simonorono\Devlog\Actions\DisplayLog;
use Simonorono\Devlog\Actions\InputLog;
use Simonorono\Devlog\Data\EntryType;

class MainMenu
{
    private function getTitle(): string
    {
        $version = InstalledVersions::getRootPackage()['pretty_version'] ?? 'unknown version';

        return "DevLog - $version";
    }

    /**
     * @throws InvalidTerminalException
     */
    public function open(): void
    {
        (new CliMenuBuilder)
            ->setTitle($this->getTitle())
            ->addItem('Log', (new InputLog(EntryType::Log)))
            ->addItem('Meeting', (new InputLog(EntryType::Meeting)))
            ->addItem('Show log', (new DisplayLog()))
            ->build()
            ->open();
    }
}
