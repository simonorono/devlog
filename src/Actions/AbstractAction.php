<?php

namespace Simonorono\Devlog\Actions;

use PhpSchool\CliMenu\CliMenu;
use Simonorono\Devlog\Storage\FileStorage;

abstract class AbstractAction
{
    public function __construct(protected FileStorage $storage)
    {
    }

    abstract public function __invoke(CliMenu $menu): void;
}
