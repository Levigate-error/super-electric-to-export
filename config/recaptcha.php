<?php

return [
    'google-recaptcha-check-url' => env('GOOGLE_RECAPTCHA_CHECK_URL', 'https://www.google.com/recaptcha/api/siteverify'),
    'google-recaptcha-secret' => env('GOOGLE_RECAPTCHA_SECRET'),
    'google-recaptcha-site-key' => env('GOOGLE_RECAPTCHA_SITE_KEY'),
];
