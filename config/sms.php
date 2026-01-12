<?php

return [

    'api_url_send' => env('SMS_API_URL_FOR_SEND'),

    'client_id' => env('SMS_CLIENT_ID'),

    'client_secret' => env('SMS_CLIENT_SECRET'),

    'dev_mode' => env('SMS_DEV_MODE', true),

    'max_retries' => 5,

    'retry_delay' => 2,

];
