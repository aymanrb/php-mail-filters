<?php

declare(strict_types=1);

namespace MailFilters\Filters;

use Ddeboer\Imap\Message;
use MailFilters\Actions\AbstractBaseAction;
use MailFilters\Adapters\MailMessageAdapterInterface;
use MailFilters\Criteria\AbstractCriterion;

class Filter
{
    /**
     * The name of the current filter (optional)
     * @var string
     */
    protected $name;

    /**
     * The criteria to be check against for this filter
     * @var AbstractCriterion[]
     */
    protected $criteria = [];

    /**
     * The actions to be applied on matched messages
     * @var AbstractBaseAction[]
     */
    protected $actions = [];

    /**
     * A flag to be set to true if the filter criteria is matched
     * @var bool
     */
    protected $filterMatched = false;

    /**
     * Parameters the filter should return back
     * @var array
     */
    protected $filterReturns = [];

    /**
     * Sets the name of the filter if needed
     *
     * @param string $name
     *
     * @return Filter
     */
    public function setName(string $name): Filter
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Adds a new action to be implemented if the filter matches
     *
     * @param AbstractBaseAction $action
     *
     * @return Filter
     */
    public function addAction(AbstractBaseAction $action): Filter
    {
        $this->actions[] = $action;

        return $this;
    }

    /**
     * clears all previously added actions from current filter
     */
    public function clearActions()
    {
        $this->actions = [];
    }

    /**
     * Adds a Criterion to check the given email message against
     *
     * @param AbstractCriterion $criterion
     *
     * @return Filter
     */
    public function addCriterion(AbstractCriterion $criterion): Filter
    {
        $this->criteria[] = $criterion;

        return $this;
    }

    /**
     * clears all previously added criteria from current filter
     */
    public function clearCriteria()
    {
        $this->criteria = [];
    }

    /**
     * Returns true if the current filter criteria were matched against the given message
     *
     * @return bool
     */
    public function isFiltered()
    {
        return $this->filterMatched;
    }

    /**
     * @return array
     */
    public function getFilterReturns()
    {
        return $this->filterReturns;
    }

    /**
     * Runs through each given criterion and checks it against the message. If it matches, it triggers the actions.
     *
     * @param MailMessageAdapterInterface $mailMessage
     */
    public function applyFilter(MailMessageAdapterInterface $mailMessage)
    {
        $this->resetFilter();

        foreach ($this->criteria as $criterion) {
            if ($criterion->checkCriterion($mailMessage)) {
                $this->triggerActions($mailMessage);

                return;
            }
        }
    }

    /**
     * Runs through each given action and triggers it on the given message
     *
     * @param MailMessageAdapterInterface $mailMessage
     */
    private function triggerActions(MailMessageAdapterInterface $mailMessage)
    {
        $this->filterMatched = true;

        foreach ($this->actions as $filterAction) {
            $this->filterReturns += $filterAction->triggerAction($mailMessage);
        }
    }

    /**
     * clears the filter results from the previous message
     */
    private function resetFilter()
    {
        $this->filterMatched = false;
        $this->filterReturns = [];
    }
}
