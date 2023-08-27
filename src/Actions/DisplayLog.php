<?php

namespace Simonorono\Devlog\Actions;

use PhpSchool\CliMenu\CliMenu;

class DisplayLog extends AbstractAction
{
    public function __invoke(CliMenu $menu): void
    {
        $menu->redraw(true);

        $entries = $this->storage->allEntries();

        $text = implode(PHP_EOL.PHP_EOL, array_map(fn ($e) => (string) $e, $entries));

        echo $text;
    }
}
