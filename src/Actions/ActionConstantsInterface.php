<?php

namespace MailFilters\Actions;

interface ActionConstantsInterface
{
    public const USER_SPECIFIC_PARAMETERS = 'params';
    public const IS_DELETED = 'is_deleted';
    public const IS_COPIED = 'is_copied';
    public const IS_MOVED = 'is_moved';
    public const STATUS_CHANGED = 'status_changed';
    public const NEW_DIRECTORY = 'new_directory';
}
