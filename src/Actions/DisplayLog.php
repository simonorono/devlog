<?php

namespace Simonorono\Devlog\Actions;

use PhpSchool\CliMenu\CliMenu;
use Simonorono\Devlog\Storage\FileStorage;

class DisplayLog extends AbstractAction
{
    public function __invoke(CliMenu $menu): void
    {
        $menu->redraw(true);

        $fileStorage = new FileStorage();

        $entries = $fileStorage->allEntries();

        $text = implode(PHP_EOL.PHP_EOL, array_map(fn($e) => (string)$e,$entries));

        echo $text;
    }
}