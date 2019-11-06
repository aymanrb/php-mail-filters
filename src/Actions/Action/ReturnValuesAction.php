<?php

declare(strict_types=1);

namespace MailFilters\Actions\Action;

use MailFilters\Actions\AbstractBaseAction;
use MailFilters\Actions\ActionConstantsInterface;
use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Exception\MailActionException;

class ReturnValuesAction extends AbstractBaseAction
{
    /**
     * @param array $returnParameters
     * @throws MailActionException
     */
    public function __construct(array $returnParameters)
    {
        if (empty($returnParameters)) {
            throw new MailActionException('Return action parameters are empty!');
        }

        $this->actionReturns = $returnParameters;
    }

    /**
     * @param MailMessageAdapterInterface $filteredMessage
     */
    public function triggerAction(MailMessageAdapterInterface $filteredMessage): void
    {
        $this->actionReturns = [
            ActionConstantsInterface::USER_SPECIFIC_PARAMETERS => $this->getActionReturns()
        ];
    }
}
