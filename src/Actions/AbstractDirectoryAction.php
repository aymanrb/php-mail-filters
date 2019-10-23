<?php

declare(strict_types=1);

namespace MailFilters\Actions;

abstract class AbstractDirectoryAction extends AbstractBaseAction
{
    /**
     * The name of the directory to apply the action on (Move to  / Copy to for example)
     * @var string
     */
    protected $destinationDirectoryName;

    public function __construct(string $destinationDirectoryName)
    {
        $this->destinationDirectoryName = $destinationDirectoryName;
    }
}
