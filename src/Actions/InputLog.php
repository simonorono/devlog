<?php

namespace Simonorono\Devlog\Actions;

use Carbon\Carbon;
use PhpSchool\CliMenu\CliMenu;
use Simonorono\Devlog\Data\Entry;
use Simonorono\Devlog\Data\EntryType;
use Simonorono\Devlog\Storage\FileStorage;

class InputLog extends AbstractAction
{
    const MIN_STRLEN = 3;

    const VALIDATION_MESSAGE = 'Please enter at least '.self::MIN_STRLEN.' characters';

    const SUCCESS_MESSAGE = 'Entry logged';

    public function __construct(FileStorage $storage, protected EntryType $type)
    {
        parent::__construct($storage);
    }

    private static function validateInput(string $text): bool
    {
        return strlen($text) >= self::MIN_STRLEN;
    }

    public function __invoke(CliMenu $menu): void
    {
        $text = $menu->askText()
            ->setValidator(fn ($t) => self::validateInput($t))
            ->setValidationFailedText(self::VALIDATION_MESSAGE)
            ->ask()
            ->fetch();

        if (empty($text)) {
            return;
        }

        $this->storage->addEntry(
            new Entry(Carbon::now(), $this->type, $text)
        );

        $flash = $menu->flash(self::SUCCESS_MESSAGE);
        $flash->display();
    }
}
