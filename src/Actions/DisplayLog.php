<?php

namespace Simonorono\Devlog\Actions;

use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use Simonorono\Devlog\Data\Entry;

class DisplayLog extends AbstractAction
{
    public function __invoke(CliMenuBuilder $builder): void
    {
        $builder->setTitle('Log');

        $currentDate = null;

        foreach ($this->storage->allEntries() as $entry) {
            /** @var Entry $entry */
            $date = $entry->timestamp->toDateString();

            if ($currentDate != $date) {
                $currentDate = $date;
                $builder->addStaticItem($currentDate);
            }

            $builder->addStaticItem('  '.$entry);
        }
    }
}
