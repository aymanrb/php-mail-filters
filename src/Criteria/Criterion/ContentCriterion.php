<?php

declare(strict_types=1);

namespace MailFilters\Criteria\Criterion;

use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Criteria\AbstractCriterion;

class ContentCriterion extends AbstractCriterion
{
    /**
     * @param MailMessageAdapterInterface $mailMessage
     *
     * @return bool
     */
    public function checkCriterion(MailMessageAdapterInterface $mailMessage): bool
    {
        $mailBody = $this->getMailBody($mailMessage);

        foreach ($this->getValues() as $value) {
            if ($this->partialFilterMatch($mailBody, $value)) {
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
        if ($mailMessage->getBodyText() !== null) {
            return $mailMessage->getBodyText();
        }

        return $mailMessage->getBodyHtml();
    }
}
