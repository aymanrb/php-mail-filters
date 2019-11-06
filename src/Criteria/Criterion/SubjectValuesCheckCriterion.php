<?php

declare(strict_types=1);

namespace MailFilters\Criteria\Criterion;

use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Criteria\AbstractValuesCheckCriterion;

class SubjectValuesCheckCriterion extends AbstractValuesCheckCriterion
{
    /**
     * @param MailMessageAdapterInterface $mailMessage
     * @return bool
     */
    public function checkCriterion(MailMessageAdapterInterface $mailMessage): bool
    {
        foreach ($this->getValues() as $subjectFilter) {
            if ($this->partialFilterMatch($subjectFilter, $mailMessage->getSubject())) {
                return true;
            }
        }

        return false;
    }
}
