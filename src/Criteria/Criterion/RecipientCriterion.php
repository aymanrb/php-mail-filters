<?php

declare(strict_types=1);

namespace MailFilters\Criteria\Criterion;

use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Criteria\AbstractCriterion;

class RecipientCriterion extends AbstractCriterion
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

        foreach ($this->getValues() as $filter_value) {
            foreach ($toMails as $recipientMail) {
                if ($this->partialFilterMatch($filter_value, $recipientMail)) {
                    return true;
                }
            }
        }

        return false;
    }
}
