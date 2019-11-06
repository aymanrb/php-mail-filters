<?php
require_once __DIR__ . '/connection/DdeboerImapConnection.php';

use MailFilters\Actions\Action\MoveMailAction;
use MailFilters\Actions\Action\ReturnValuesAction;
use MailFilters\Criteria\Criterion\SubjectValuesCheckCriterion;
use MailFilters\Filters\Filter;
use MailFilters\MailFiltersCollection;

//prepare the criteria
$welcomeSubjectCriterion = new SubjectValuesCheckCriterion('*Welcome*');

//prepare the actions
$returnValuesAction = new ReturnValuesAction(['specialIdSubject' => true]);
$moveToFolderAction = new MoveMailAction('New Directory');

//build the filter
$subjectFilter = new Filter();
$subjectFilter
    ->setName('Mails that contains an RID in the subject')
    ->addCriterion($welcomeSubjectCriterion)
    ->addAction($returnValuesAction)
    ->addAction($moveToFolderAction);


$mailFilters = new MailFiltersCollection();
$mailFilters->addFilter($subjectFilter);

foreach ($allMessages as $message) {
    $mailMessageAdapter->setMessage($message);

    $mailFilters->applyFilters($mailMessageAdapter);

    if ($mailFilters->isFiltered()) {
        print_r($mailFilters->getFilterReturns());
    }
}
