<?php

declare(strict_types=1);

namespace MailFilters\Criteria\Criterion;

use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Criteria\AbstractCriterion;
use MailFilters\Exception\MailCriteriaException;

class AttachmentsCriterion extends AbstractCriterion
{
    /**
     * @param MailMessageAdapterInterface $mailMessage
     *
     * @return Bool
     */
    public function checkCriterion(MailMessageAdapterInterface $mailMessage): bool
    {
        return $mailMessage->hasAttachments();
    }

    /**
     * @param array $values
     * @throws MailCriteriaException
     */
    public function setValues(array $values): void
    {
        throw new MailCriteriaException('setValues() call is not allowed for AttachmentsMailCriteria.');
    }
}
