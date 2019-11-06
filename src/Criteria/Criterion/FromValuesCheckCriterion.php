<?php

declare(strict_types=1);

namespace MailFilters\Criteria\Criterion;

use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Criteria\AbstractValuesCheckCriterion;

class FromValuesCheckCriterion extends AbstractValuesCheckCriterion
{
    /**
     * @param MailMessageAdapterInterface $mailMessage
     *
     * @return bool
     */
    public function checkCriterion(MailMessageAdapterInterface $mailMessage): bool
    {
        foreach ($this->getValues() as $filterValue) {
            if ($this->partialFilterMatch($filterValue, $mailMessage->getSenderAddress())) {
                return true;
            }
        }

        return false;
    }
}
