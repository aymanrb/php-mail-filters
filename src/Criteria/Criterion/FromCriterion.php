<?php

declare(strict_types=1);

namespace MailFilters\Criteria\Criterion;

use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Criteria\AbstractCriterion;

class FromCriterion extends AbstractCriterion
{
    /**
     * @param MailMessageAdapterInterface $mailMessage
     *
     * @return bool
     */
    public function checkCriterion(MailMessageAdapterInterface $mailMessage): bool
    {
        foreach ($this->getValues() as $filter_value) {
            if ($this->partialFilterMatch($filter_value, $mailMessage->getSenderAddress())) {
                return true;
            }
        }

        return false;
    }
}
