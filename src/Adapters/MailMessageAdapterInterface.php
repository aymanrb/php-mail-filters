<?php

declare(strict_types=1);

namespace MailFilters\Adapters;

interface MailMessageAdapterInterface
{
    /**
     * Copy message to another directory.
     *
     * @param string $destinationDirectoryName
     *
     * @return bool
     */
    public function copyTo(string $destinationDirectoryName): bool;

    /**
     * Move message to another directory.
     *
     * @param string $destinationDirectoryName
     *
     * @return bool
     */
    public function move(string $destinationDirectoryName): bool;

    /**
     * Delete message.
     *
     * @return bool
     */
    public function delete(): bool;

    /**
     * Mark message as read.
     *
     * @return bool
     */
    public function markAsRead(): bool;

    /**
     * Mark message as unread.
     *
     * @return bool
     */
    public function markAsUnRead(): bool;

    /**
     * Mark message as important.
     *
     * @return bool
     */
    public function markMessageAsImportant(): bool;

    /**
     * Does this message have attachments?
     *
     * @return bool
     */
    public function hasAttachments(): bool;

    /**
     * Get body text.
     *
     * @return null|string
     */
    public function getBodyText(): string;

    /**
     * Get body text.
     *
     * @return null|string
     */
    public function getBodyHtml(): string;

    /**
     * Get message sender address (from headers).
     *
     * @return string
     */
    public function getSenderAddress(): string;

    /**
     * Get recipient address(es) in TO headers.
     *
     * @return array
     */
    public function getToAddresses(): array;

    /**
     * Get recipient address(es) in CC headers.
     *
     * @return array
     */
    public function getCcAddresses(): array;

    /**
     * Get recipient address(es) in BCC headers.
     *
     * @return array
     */
    public function getBccAddresses(): array;

    /**
     * Get message subject
     *
     * @return array
     */
    public function getSubject(): string;
}
