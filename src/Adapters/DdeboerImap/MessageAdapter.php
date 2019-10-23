<?php

declare(strict_types=1);

namespace MailFilters\Adapters\DdeboerImap;

use Ddeboer\Imap\ConnectionInterface;
use Ddeboer\Imap\Message;
use MailFilters\Adapters\MailMessageAdapterInterface;

class MessageAdapter implements MailMessageAdapterInterface
{
    /** @var ConnectionInterface */
    private $imapConnection;

    /** @var Message */
    private $imapMessage;


    public function __construct(ConnectionInterface $imapConnection)
    {
        $this->imapConnection = $imapConnection;
    }

    public function setMessage(Message $imapMessage)
    {
        $this->imapMessage = $imapMessage;
    }

    protected function extractAddressesFromObjectsArray(array $addressObjects): array
    {
        $returns = [];

        /** @var Message\EmailAddress $addressObject */
        foreach ($addressObjects as $addressObject) {
            $returns[] = $addressObject->getAddress();
        }

        return $returns;
    }


    public function copyTo(string $destinationDirectoryName): bool
    {
        $destinationMailbox = $this->imapConnection->getMailbox($destinationDirectoryName);

        $this->imapMessage->copy($destinationMailbox);

        return true;
    }

    public function move(string $destinationDirectoryName): bool
    {
        $destinationMailbox = $this->imapConnection->getMailbox($destinationDirectoryName);

        $this->imapMessage->move($destinationMailbox);

        return true;
    }

    public function delete(): bool
    {
        $this->imapMessage->delete();

        return true;
    }

    public function markAsRead(): bool
    {
        return $this->imapMessage->markAsSeen();
    }

    public function markAsUnRead(): bool
    {
        return $this->imapMessage->clearFlag('\Seen');
    }

    public function markMessageAsImportant(): bool
    {
        return $this->imapMessage->setFlag('\Flagged');
    }

    public function hasAttachments(): bool
    {
        return $this->imapMessage->hasAttachments();
    }

    public function getBodyText(): string
    {
        return (string)$this->imapMessage->getBodyText();
    }

    public function getBodyHtml(): string
    {
        return (string)$this->imapMessage->getBodyHtml();
    }

    public function getSenderAddress(): string
    {
        $senderAddressObj = $this->imapMessage->getFrom();

        if (empty($senderAddressObj)) {
            return '';
        }

        return (string)$senderAddressObj->getAddress();
    }

    public function getToAddresses(): array
    {
        return $this->extractAddressesFromObjectsArray($this->imapMessage->getTo());
    }

    public function getCcAddresses(): array
    {
        return $this->extractAddressesFromObjectsArray($this->imapMessage->getCc());
    }

    public function getBccAddresses(): array
    {
        return $this->extractAddressesFromObjectsArray($this->imapMessage->getBcc());

    }

    public function getSubject(): string
    {
        return (string)$this->imapMessage->getSubject();
    }
}