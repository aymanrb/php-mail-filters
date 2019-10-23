<?php

declare(strict_types=1);

namespace MailFilters\Actions\Action;

use MailFilters\Actions\AbstractBaseAction;
use MailFilters\Adapters\MailMessageAdapterInterface;

class DeleteAction extends AbstractBaseAction
{
    /**
     * @param MailMessageAdapterInterface $filteredMessage
     *
     * @return array
     */
    public function triggerAction(MailMessageAdapterInterface $filteredMessage): array
    {
        $filteredMessage->delete();

        return ['Message Deleted' => true];

    }
}
