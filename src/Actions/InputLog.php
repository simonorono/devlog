<?php

namespace Simonorono\Devlog\Actions;

use PhpSchool\CliMenu\CliMenu;

class InputLog extends AbstractAction
{
    const MIN_STRLEN = 3;

    const VALIDATION_MESSAGE = 'Please enter at least '.self::MIN_STRLEN.' characters';

    const SUCCESS_MESSAGE = 'Entry logged';

    private static function validateInput(string $text): bool
    {
        return strlen($text) > self::MIN_STRLEN;
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

        $flash = $menu->flash(self::SUCCESS_MESSAGE);
        $flash->display();
    }
}
