<?php

use Ddeboer\Imap\Server;
use Symfony\Component\Yaml\Yaml;
use MailFilters\Adapters\DdeboerImap\MessageAdapter;

$config = Yaml::parse(file_get_contents(__DIR__ . '/../config/config.yml'), Yaml::PARSE_OBJECT);

$server = new Server($config['imap_connection']['imap_server']);
$connection = $server->authenticate($config['imap_connection']['username'], $config['imap_connection']['password']);
$mailMessageAdapter = new MessageAdapter($connection);
$mailbox = $connection->getMailbox('INBOX');

$allMessages = $mailbox->getMessages();