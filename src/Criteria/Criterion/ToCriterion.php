<?php

declare(strict_types=1);

namespace MailFilters\Criteria\Criterion;

use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Criteria\AbstractCriterion;

class ToCriterion extends AbstractCriterion
{
    /**
     * @param MailMessageAdapterInterface $mailMessage
     * @return bool
     */
    public function checkCriterion(MailMessageAdapterInterface $mailMessage): bool
    {
        foreach ($this->getValues() as $filter_value) {
            foreach ($mailMessage->getToAddresses() as $toEmailAddress) {
                if ($this->partialFilterMatch($filter_value, $toEmailAddress)) {
                    return true;
                }
            }
        }

        return false;
    }
}
