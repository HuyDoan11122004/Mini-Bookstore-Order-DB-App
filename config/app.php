<?php

return [
    'name' => 'Mini Bookstore Order DB App',
    'environment' => getenv('APP_ENV') ?: 'production',
    'debug' => filter_var(getenv('APP_DEBUG') ?: false, FILTER_VALIDATE_BOOLEAN),
    'base_url' => getenv('APP_BASE_URL') ?: 'http://localhost:8000',
];
