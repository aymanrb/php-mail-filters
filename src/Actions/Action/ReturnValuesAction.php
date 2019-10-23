<?php

declare(strict_types=1);

namespace MailFilters\Actions\Action;

use MailFilters\Actions\AbstractBaseAction;
use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Exception\MailActionException;

class ReturnValuesAction extends AbstractBaseAction
{
    /**
     * @var array
     */
    protected $returnParameters = [];

    /**
     * @param array $returnParameters
     */
    public function __construct(array $returnParameters)
    {
        $this->returnParameters = $returnParameters;
    }

    /**
     * @param MailMessageAdapterInterface $filteredMessage
     * @throws MailActionException
     *
     * @return array
     */
    public function triggerAction(MailMessageAdapterInterface $filteredMessage): array
    {
        $this->validateActionParameters();

        return $this->getReturnParameters();
    }

    /**
     * @return array
     */
    public function getReturnParameters(): array
    {
        return $this->returnParameters;
    }

    /**
     * @throws MailActionException
     */
    protected function validateActionParameters()
    {
        if (empty($this->returnParameters)) {
            throw new MailActionException('Return action parameters are empty!');
        }
    }
}
