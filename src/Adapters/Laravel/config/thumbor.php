<?php
/**
 * @author Alexander Tebiev - https://github.com/beeyev
 */
declare(strict_types=1);

return [
    /*
    | The same security key used in the thumbor service to match the URL construction.
    */
    'security_key' => env('THUMBOR_SECURITY_KEY'),

    /*
    | Thumbor server base URL, will be used as prefix to the generated URL.
    */
    'base_url' => env('THUMBOR_SERVER_URL'),
];
