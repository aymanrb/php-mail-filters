<?php

declare(strict_types=1);

namespace MailFilters\Criteria\Criterion;

use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Criteria\AbstractValuesCheckCriterion;

class ContentCriterion extends AbstractValuesCheckCriterion
{
    /**
     * @param MailMessageAdapterInterface $mailMessage
     *
     * @return bool
     */
    public function checkCriterion(MailMessageAdapterInterface $mailMessage): bool
    {
        $mailBody = $this->getMailBody($mailMessage);

        foreach ($this->getValues() as $filterValue) {
            if ($this->partialFilterMatch($filterValue, $mailBody)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param MailMessageAdapterInterface $mailMessage
     *
     * @return string
     */
    private function getMailBody(MailMessageAdapterInterface $mailMessage): string
    {
        if (!empty($mailMessage->getBodyText())) {
            return $mailMessage->getBodyText();
        }

        return strip_tags($mailMessage->getBodyHtml());
    }
}
