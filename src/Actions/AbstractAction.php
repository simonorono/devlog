<?php

namespace Simonorono\Devlog\Actions;

use PhpSchool\CliMenu\CliMenu;

abstract class AbstractAction
{
    abstract public function __invoke(CliMenu $menu): void;
}
