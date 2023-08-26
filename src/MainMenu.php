<?php

namespace Simonorono\Devlog;

use Composer\InstalledVersions;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use PhpSchool\CliMenu\Exception\InvalidTerminalException;

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
            ->build()
            ->open();
    }
}
