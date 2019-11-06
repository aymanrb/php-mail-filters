<?php

declare(strict_types=1);

namespace MailFilters\Actions;

use MailFilters\Adapters\MailMessageAdapterInterface;

abstract class AbstractBaseAction
{
    /**
     * The parameters to be returned from each action
     * @var array
     */
    protected $actionReturns = [];

    /**
     * Gets the parameters to be returned from current action
     *
     * @return array
     */
    public function getActionReturns()
    {
        return $this->actionReturns;
    }

    /**
     * @param MailMessageAdapterInterface $filteredMessage
     */
    abstract public function triggerAction(MailMessageAdapterInterface $filteredMessage): void;
}
