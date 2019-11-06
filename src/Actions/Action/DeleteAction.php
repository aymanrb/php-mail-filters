<?php

declare(strict_types=1);

namespace MailFilters\Actions\Action;

use MailFilters\Actions\AbstractBaseAction;
use MailFilters\Actions\ActionConstantsInterface;
use MailFilters\Adapters\MailMessageAdapterInterface;

class DeleteAction extends AbstractBaseAction
{
    /**
     * @param MailMessageAdapterInterface $filteredMessage
     *
     * @return array
     */
    public function triggerAction(MailMessageAdapterInterface $filteredMessage): void
    {
        $isDeleted = $filteredMessage->delete();

        $this->actionReturns = [
            ActionConstantsInterface::IS_DELETED => $isDeleted,
        ];
    }
}
