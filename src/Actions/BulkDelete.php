<?php

namespace Simonorono\Devlog\Actions;

use Carbon\Carbon;
use PhpSchool\CliMenu\CliMenu;
use Simonorono\Devlog\Data\Entry;

class BulkDelete extends AbstractAction
{
    public function __invoke(CliMenu $menu)
    {
        $daysToRetain = (int) $menu->askNumber()
            ->setPromptText('How many days to retain?')
            ->ask()
            ->fetch();

        $threshold = Carbon::now()->subDays($daysToRetain);

        foreach ($this->storage->allEntries() as $entry) {
            /** @var Entry $entry */
            if ($entry->timestamp->isBefore($threshold)) {
                $this->storage->deleteEntry($entry);
            }
        }

        $flash = $menu->flash('Mass delete done');
        $flash->display();
    }
}
