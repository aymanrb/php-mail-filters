PHP Mail Filters Library
===========================

This is a PHP package that enables you to create handy filtering features on E-mail messages (similar to that of Gmail filters feature) utilizing the [PHP IMAP extension](https://php.net/manual/book.imap.php). The library makes it easy to hook up your own IMAP connection to it, all you need to do is implement few adapter methods for your library needed for the filtering and actions functionality.

Currently the adapter is implemented for the following IMAP libraries: 
- [ddeboer/imap](https://github.com/ddeboer/imap) 
- [barbushin/php-imap](https://github.com/barbushin/php-imap)

### Features:
 * **Apply filters your E-mail messages by setting criteria over the following fields:**
 	- To
 	- All Recipients (To, Cc, Bcc)
 	- Subject
 	- From
	- Body Text
	- Attachments

 * **Take one of the following actions based on matched filters:**
 	- Delete message from your mailbox.
 	- Move the message to a different mail folder.
 	- Copy the message to another mail folder.
 	- Return user specified variables.
 	- Mark message status (Read, Unread and Important)
 	
 ### Requirements:
 * PHP 7.2+
 * PHP IMAP extension must be installed and activated
 * A PHP IMAP library to read messages (preferably use one of the 2 listed above if you have none, or write an adapter to the one you are using) 
 	
 ### Example:
 
 ```php
 //Step 1: Build the filter(s) with Criteria and Actions 
 $mailFilter = new Filter();
 $mailFilter
    ->setName('Move mails that contains "RID" in its subject to Tagged folder')
    ->addCriterion(new SubjectCriterion('*RID*'))
    ->addAction(new MoveMailAction('Tagged'));

 $mailFilters = new MailFilter();
 $mailFilters->addFilter($mailFilter);

 // Step 2: Read the message
 $mailbox = new PhpImap\Mailbox(
    '{imap.example.org:993/imap/ssl}INBOX',
    'username@example.org',
    'SecretPassword'
 );

 $mailMessageAdapter = new MailFilters\Adapters\BarbushinImap\MessageAdapter($mailbox);
 $messageIds = $mailbox->searchMailbox('ALL');
 $firstMessage = $mailbox->getMail();
 
 
 // Step 3: Apply filters to message
 $mailMessageAdapter->setMessage($firstMessage)
 $mailFilters->applyFilters($mailMessageAdapter);
 ```
 
 The above example will check if the given email contains "RID" in its subject and move the message to a new MailBox "Tagged" directory.


##### In Progress (Unfinished work):
 * Adding unit and functional tests to the library