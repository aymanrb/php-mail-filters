<?php

declare(strict_types=1);

namespace MailFilters\Criteria\Criterion;

use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Criteria\AbstractValuesCheckCriterion;

class ToCriterion extends AbstractValuesCheckCriterion
{
    /**
     * @param MailMessageAdapterInterface $mailMessage
     * @return bool
     */
    public function checkCriterion(MailMessageAdapterInterface $mailMessage): bool
    {
        foreach ($this->getValues() as $filterValue) {
            foreach ($mailMessage->getToAddresses() as $toEmailAddress) {
                if ($this->partialFilterMatch($filterValue, $toEmailAddress)) {
                    return true;
                }
            }
        }

        return false;
    }
}
