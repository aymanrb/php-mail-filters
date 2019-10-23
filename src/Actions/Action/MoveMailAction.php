<?php

declare(strict_types=1);

namespace MailFilters\Actions\Action;

use MailFilters\Actions\AbstractDirectoryAction;
use MailFilters\Adapters\MailMessageAdapterInterface;

class MoveMailAction extends AbstractDirectoryAction
{
    /**
     * @param MailMessageAdapterInterface $filteredMessage
     *
     * @return array
     */
    public function triggerAction(MailMessageAdapterInterface $filteredMessage): array
    {
        $filteredMessage->move($this->destinationDirectoryName);

        return ['Message Moved' => $this->destinationDirectoryName];
    }
}
