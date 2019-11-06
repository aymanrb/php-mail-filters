<?php

declare(strict_types=1);

namespace MailFilters\Actions\Action;

use MailFilters\Actions\AbstractDirectoryAction;
use MailFilters\Actions\ActionConstantsInterface;
use MailFilters\Adapters\MailMessageAdapterInterface;

class MoveMailAction extends AbstractDirectoryAction
{
    /**
     * @param MailMessageAdapterInterface $filteredMessage
     */
    public function triggerAction(MailMessageAdapterInterface $filteredMessage): void
    {
        $isMoved = $filteredMessage->moveTo($this->destinationDirectoryName);

        $this->actionReturns = [
            ActionConstantsInterface::IS_MOVED => $isMoved,
        ];

        if ($isMoved) {
            $this->actionReturns[ActionConstantsInterface::NEW_DIRECTORY] = $this->destinationDirectoryName;
        }
    }
}
