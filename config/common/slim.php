<?php

declare(strict_types=1);

return [
    'settings' => [
        'addContentLengthHeader' => true,
        'displayErrorDetails' => (bool)getenv('API_DEBUG'),
    ],
];
