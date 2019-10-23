<?php

declare(strict_types=1);

namespace MailFilters\Actions\Action;

use MailFilters\Actions\AbstractDirectoryAction;
use MailFilters\Adapters\MailMessageAdapterInterface;

class CopyAction extends AbstractDirectoryAction
{
    /**
     * @param MailMessageAdapterInterface $filteredMessage
     *
     * @return array
     */
    public function triggerAction(MailMessageAdapterInterface $filteredMessage): array
    {
        $filteredMessage->copyTo($this->destinationDirectoryName);

        return ['Message Copied' => $this->destinationDirectoryName];
    }
}
