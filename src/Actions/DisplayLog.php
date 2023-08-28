<?php

namespace Simonorono\Devlog\Actions;

use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use PhpSchool\CliMenu\CliMenu;
use PhpSchool\CliMenu\Exception\InvalidTerminalException;
use Simonorono\Devlog\Data\Entry;

class DisplayLog extends AbstractAction
{
    /**
     * @throws InvalidTerminalException
     */
    public function __invoke(CliMenu $menu): void
    {
        $builder = (new CliMenuBuilder())
            ->setTitle('Log');

        $currentDate = null;

        foreach ($this->storage->allEntries() as $entry) {
            /** @var Entry $entry */
            $date = $entry->timestamp->toDateString();

            if ($currentDate != $date) {
                $currentDate = $date;

                $builder->addStaticItem("[$date]");
            }

            if ($entry->isMeeting()) {
                $builder->addLineBreak('');
            }

            $builder->addStaticItem("  $entry");

            if ($entry->isMeeting()) {
                $builder->addLineBreak('');
            }
        }

        $builder->setMarginAuto()->build()->open();

        $menu->redraw(true);
    }
}
