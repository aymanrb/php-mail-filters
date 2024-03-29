<?php

declare(strict_types=1);

namespace MailFilters\Actions\Action;

use MailFilters\Actions\AbstractBaseAction;
use MailFilters\Actions\ActionConstantsInterface;
use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Exception\MailActionException;

class MarkStatusAction extends AbstractBaseAction
{
    const SET_MSG_READ = 'read';
    const SET_MSG_UNREAD = 'unread';
    const SET_MSG_IMPORTANT = 'important';

    /** @var string */
    protected $targetStatus;

    /**
     * @param string $targetStatus
     */
    public function __construct($targetStatus)
    {
        $this->targetStatus = $targetStatus;
    }

    /**
     * @param MailMessageAdapterInterface $filteredMessage
     * @throws MailActionException
     */
    public function triggerAction(MailMessageAdapterInterface $filteredMessage): void
    {
        switch ($this->targetStatus) {
            case self::SET_MSG_READ:
                $filteredMessage->markAsRead();
                break;
            case self::SET_MSG_UNREAD:
                $filteredMessage->markAsUnread();
                break;
            case self::SET_MSG_IMPORTANT:
                $filteredMessage->markMessageAsImportant();
                break;
            default:
                throw new MailActionException('Unknown target status: ' . $this->targetStatus);
        }

        $this->actionReturns = [
            ActionConstantsInterface::STATUS_CHANGED => ucwords($this->targetStatus)
        ];
    }
}
