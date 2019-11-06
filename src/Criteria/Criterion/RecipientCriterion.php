<?php

declare(strict_types=1);

namespace MailFilters\Criteria\Criterion;

use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Criteria\AbstractValuesCheckCriterion;

class RecipientCriterion extends AbstractValuesCheckCriterion
{
    /**
     * @param MailMessageAdapterInterface $mailMessage
     * @return bool
     */
    public function checkCriterion(MailMessageAdapterInterface $mailMessage): bool
    {
        $toMails = array_merge(
            $mailMessage->getToAddresses(),
            $mailMessage->getCcAddresses(),
            $mailMessage->getBccAddresses()
        );

        foreach ($this->getValues() as $filterValue) {
            foreach ($toMails as $recipientMail) {
                if ($this->partialFilterMatch($filterValue, $recipientMail)) {
                    return true;
                }
            }
        }

        return false;
    }
}
