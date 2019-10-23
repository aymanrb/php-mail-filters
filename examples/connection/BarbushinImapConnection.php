<?php

use MailFilters\Adapters\BarbushinImap\MessageAdapter;
use Symfony\Component\Yaml\Yaml;

$config = Yaml::parse(file_get_contents(__DIR__ . '/../config/config.yml'), Yaml::PARSE_OBJECT);

$mailbox = new PhpImap\Mailbox(
    '{' . $config['imap_connection']['imap_server'] . ':993/imap/ssl}INBOX',
    $config['imap_connection']['username'],
    $config['imap_connection']['password']
);

$mailMessageAdapter = new MessageAdapter($mailbox);
$messageIds = $mailbox->searchMailbox('ALL');