<?php

declare(strict_types=1);

namespace MailFilters\Actions\Action;

use MailFilters\Actions\AbstractDirectoryAction;
use MailFilters\Actions\ActionConstantsInterface;
use MailFilters\Adapters\MailMessageAdapterInterface;

class CopyAction extends AbstractDirectoryAction
{
    /**
     * @param MailMessageAdapterInterface $filteredMessage
     */
    public function triggerAction(MailMessageAdapterInterface $filteredMessage): void
    {
        $isCopied = $filteredMessage->copyTo($this->destinationDirectoryName);

        $this->actionReturns = [
            ActionConstantsInterface::IS_COPIED => $isCopied,
        ];

        if ($isCopied) {
            $this->actionReturns[ActionConstantsInterface::NEW_DIRECTORY] = $this->destinationDirectoryName;
        }
    }
}
