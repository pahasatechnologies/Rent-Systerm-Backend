<?php

return [
    'url' => env('FRONTEND_URL', 'http://localhost:4200'),
    // path to my frontend page with query param queryURL(temporarySignedRoute URL)
    'email_verify_url' => env('FRONTEND_EMAIL_VERIFY_URL', '/auth/verify-email?queryURL='),
];
