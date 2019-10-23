<?php

declare(strict_types=1);

namespace MailFilters\Criteria;

use MailFilters\Adapters\MailMessageAdapterInterface;

abstract class AbstractCriterion
{
    /**
     * The values to filter against
     * @var array
     */
    protected $values = [];

    /**
     * @param string|array $values
     */
    public function __construct($values = [])
    {
        $this->setValues((array)$values);
    }

    /**
     * Set the values to be used in filtering
     *
     * @param array $values
     */
    public function setValues(array $values): void
    {
        $this->values = $values;
    }

    /**
     * Gets the values to be used in filtering
     *
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * Applies the single criterion check on the given message and returns true if it matches
     *
     * @param MailMessageAdapterInterface $mailMessage
     *
     * @return bool
     */
    abstract public function checkCriterion(MailMessageAdapterInterface $mailMessage): bool;

    /**
     * Does a partial string search for needles that contains asterix (*)
     *
     * @param string $needle
     * @param string $haystack
     *
     * @return bool
     */
    protected function partialFilterMatch(string $needle, string $haystack): bool
    {
        $searchPattern = str_replace('*', '(.*)', $needle);

        return (bool) preg_match('|' . $searchPattern . '|i', $haystack);
    }
}
