<?php

declare(strict_types=1);

namespace MailFilters\Actions\Action;

use MailFilters\Actions\AbstractBaseAction;
use MailFilters\Adapters\MailMessageAdapterInterface;

class BounceMailAction extends AbstractBaseAction
{
    /**
     * @param MailMessageAdapterInterface $filteredMessage
     *
     * @return array
     */
    public function triggerAction(MailMessageAdapterInterface $filteredMessage): array
    {
        //TODO: Implement. Create a copy of the message and forward it to the desired address

        return [];
    }
}
