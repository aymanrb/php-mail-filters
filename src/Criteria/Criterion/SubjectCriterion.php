<?php

declare(strict_types=1);

namespace MailFilters\Criteria\Criterion;

use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Criteria\AbstractCriterion;

class SubjectCriterion extends AbstractCriterion
{
    /**
     * @param MailMessageAdapterInterface $mailMessage
     * @return bool
     */
    public function checkCriterion(MailMessageAdapterInterface $mailMessage): bool
    {
        foreach ($this->getValues() as $subject_filter) {
            if ($this->partialFilterMatch($subject_filter, $mailMessage->getSubject())) {
                return true;
            }
        }

        return false;
    }
}
