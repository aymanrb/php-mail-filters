<?php
require_once __DIR__ . '/connection/BarbushinImapConnection.php';

use MailFilters\Actions\Action\MarkStatusAction;
use MailFilters\Actions\Action\ReturnValuesAction;
use MailFilters\Criteria\Criterion\ToCriterion;
use MailFilters\Filters\Filter;
use MailFilters\MailFiltersCollection;

//prepare the criteria
$toMailCriterion = new ToCriterion(['ceo@example.com', 'ceo@example.net']);

//prepare the actions
$markAsReadAction = new MarkStatusAction(MarkStatusAction::SET_MSG_READ);
$returnValuesAction = new ReturnValuesAction(['vipMessage' => true, 'receiver' => 'CEO']);

//build the filter
$mailFilter = new Filter();
$mailFilter
    ->setName('Unread and provide context for mails sent to the CEO of Example Co.')
    ->addCriterion($toMailCriterion)
    ->addAction($markAsReadAction)
    ->addAction($returnValuesAction);

$mailFilters = new MailFiltersCollection();
$mailFilters->addFilter($mailFilter);

foreach ($messageIds as $messageId) {
    $message = $mailbox->getMail($messageId, false);
    $mailMessageAdapter->setMessage($message);

    $mailFilters->applyFilters($mailMessageAdapter);

    if ($mailFilters->isFiltered()) {
        print_r($mailFilters->getFilterReturns());
    }
}