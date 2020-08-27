<?php


namespace App\Helpers;

/**
 * Interface Constants
 */
interface Constants
{
    /** @var string UUID_REGEX */
    const UUID_REGEX = '([0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12})';

    /** @var string PHONE_FORMAT  */
    const PHONE_FORMAT = '^+[0-9]{15}$';

    /** @var string TOKEN_FORMAT */
    const TOKEN_FORMAT = '^[a-zA-Z0-9]{6}$';
}
