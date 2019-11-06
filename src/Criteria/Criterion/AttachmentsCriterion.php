<?php

declare(strict_types=1);

namespace MailFilters\Criteria\Criterion;

use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Criteria\CriterionInterface;

class AttachmentsCriterion implements CriterionInterface
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
}
