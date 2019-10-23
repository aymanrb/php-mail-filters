<?php

declare(strict_types=1);

namespace MailFilters;

use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Filters\Filter;

/**
 * Filters Mail Messages based on user specified parameters and does some action on matched ones.
 *
 * The MailFiltersCollection Class is the main class that acts as a wrapper to the whole filtering process by collecting
 * the mix of Filters (Criteria and Actions) to apply on the mailbox messages.
 *
 */
class MailFiltersCollection
{
    /**
     * Holds all user added filters (Mix of Criteria and its Actions)
     * @var Filter[]
     */
    protected $filters = [];

    /**
     * Adds a new single filter entry to the class to be applied on the message
     *
     * @param Filter $filterObj ; A filter instance to apply
     *
     * @return MailFiltersCollection
     */
    public function addFilter(Filter $filterObj): MailFiltersCollection
    {
        $this->filters[] = $filterObj;

        return $this;
    }

    /**
     * Checks whether at this point any of the filters were matched on the given message
     *
     * @return bool
     */
    public function isFiltered(): bool
    {
        foreach ($this->filters as $filter) {
            if ($filter->isFiltered()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Gets the returned values of from the matched filters (if any)
     *
     * @return array
     */
    public function getFilterReturns(): array
    {
        $filterReturns = [];

        foreach ($this->filters as $filter) {
            if (!empty($filter->getFilterReturns())) {
                $filterReturns += $filter->getFilterReturns();
            }
        }

        return $filterReturns;
    }

    /**
     * The actual execution of the added filters on a new E-mail message
     *
     * @param MailMessageAdapterInterface $mailMessageAdapter
     */
    public function applyFilters(MailMessageAdapterInterface $mailMessageAdapter)
    {
        foreach ($this->filters as $filter) {
            $filter->applyFilter($mailMessageAdapter);
        }
    }
}
