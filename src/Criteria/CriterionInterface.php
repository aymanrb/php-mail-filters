<?php

declare(strict_types=1);

namespace MailFilters\Criteria;

use MailFilters\Adapters\MailMessageAdapterInterface;

interface CriterionInterface
{
    public function checkCriterion(MailMessageAdapterInterface $mailMessage): bool;
}
