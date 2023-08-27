<?php

namespace Simonorono\Devlog\Actions;

use Simonorono\Devlog\Storage\FileStorage;

abstract class AbstractAction
{
    public function __construct(protected FileStorage $storage)
    {
    }
}
