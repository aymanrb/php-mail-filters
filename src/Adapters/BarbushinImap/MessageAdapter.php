<?php

declare(strict_types=1);

namespace MailFilters\Adapters\BarbushinImap;

use MailFilters\Adapters\MailMessageAdapterInterface;
use PhpImap\IncomingMail;
use PhpImap\Mailbox;

class MessageAdapter implements MailMessageAdapterInterface
{
    /** @var Mailbox */
    private $imapMailbox;

    /** @var IncomingMail */
    private $imapMessage;


    public function __construct(Mailbox $imapMailbox)
    {
        $this->imapMailbox = $imapMailbox;
    }

    public function setMessage(IncomingMail $imapMessage)
    {
        $this->imapMessage = $imapMessage;
    }


    public function copyTo(string $destinationDirectoryName): bool
    {
        $this->imapMailbox->copyMail($this->imapMessage->id, $destinationDirectoryName);

        return true;
    }

    public function moveTo(string $destinationDirectoryName): bool
    {
        $this->imapMailbox->moveMail($this->imapMessage->id, $destinationDirectoryName);

        return true;
    }

    public function delete(): bool
    {
        $this->imapMailbox->deleteMail($this->imapMessage->id);

        return true;
    }

    public function markAsRead(): bool
    {
        $this->imapMailbox->markMailAsRead($this->imapMessage->id);

        return true;
    }

    public function markAsUnRead(): bool
    {
        $this->imapMailbox->markMailAsUnread($this->imapMessage->id);

        return true;
    }

    public function markMessageAsImportant(): bool
    {
        $this->imapMailbox->markMailAsImportant($this->imapMessage->id);

        return true;
    }

    public function hasAttachments(): bool
    {
        return $this->imapMessage->hasAttachments();
    }

    public function getBodyText(): string
    {
        return (string)$this->imapMessage->textPlain;
    }

    public function getBodyHtml(): string
    {
        return (string)$this->imapMessage->textHtml;
    }

    public function getSenderAddress(): string
    {
        if (empty($this->imapMessage->fromAddress)) {
            return '';
        }

        return (string)$this->imapMessage->fromAddress;
    }

    public function getToAddresses(): array
    {
        return array_keys($this->imapMessage->to);
    }

    public function getCcAddresses(): array
    {
        return array_keys($this->imapMessage->cc);
    }

    public function getBccAddresses(): array
    {
        return array_keys($this->imapMessage->bcc);

    }

    public function getSubject(): string
    {
        return (string)$this->imapMessage->subject;
    }
}