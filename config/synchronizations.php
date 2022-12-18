<?php

return [
    'sales_force' => [
        'debug' => true,

        'login' => env('SALES_FORCE_LOGIN', 'nikp@gbc-team.com.super'),
        'password' => env('SALES_FORCE_PASSWORD', 'GiMWbiEfK2k3Phs87biy'),

        'userSecret' => env('SALES_FORCE_USER_SECRETE', '4020340191027199299'),
        'consumerKey' => env('SALES_FORCE_USER_SECRETE', '3MVG9PhR6g6B7ps4Kax2b_1SV31FjiOQab4gm9Y_VHBMDsqnLKjQsFQznpahlWJUERrrQa_tb9pgyQ2vku68_'),
        'consumerSecret' => env('SALES_FORCE_USER_SECRETE', '4020340191027199299'),
        'apiKey' => env('SALES_FORCE_API_KEY', '3MVG9rKhT8ocoxGlxO9GmBlLybzOkMwswkL_mMX743O_T99CbcFbSDg3TmolLx1ISQWTLMN5j1m9mDbBRGeO9'),
        'apiSecret' => env('SALES_FORCE_API_SECRET', '00B15255CB8ACCEBE75E93452F7CD8ED226BACCA806921696A1A5DEFF901D343'),

        'urls' => [
            'main' => env('SALES_FORCE_URL', 'https://legrandrussia--super.lightning.force.com'),
            'auth' => env('SALES_FORCE_AUTH_URL', 'https://login.salesforce.com/services/oauth2/authorize'),
            'sandboxAuth' => env('SALES_FORCE_SANDBOX_AUTH_URL', 'https://test.salesforce.com/services/oauth2/authorize'),
            'sandboxTokenAuth' => env('SALES_FORCE_SANDBOX_AUTH_URL', 'https://test.salesforce.com/services/oauth2/token'),
            'sobjects_main_url' => env('SOBJECTS_MAIN_URL', 'services/data/v47.0/sobjects/'),
        ],
    ],
    'beatle' => [
        'baseUrl' => 'http://80.87.202.138:7322/api/se',
        'testBaseUrl' => 'http://80.87.202.138:7322/api/se',
        'testAuthToken' => 'ZZfkG3DrDGc3iYWALgbdWHIi9XyOrTM0',
        'prodAuthToken' => 'ZZfkG3DrDGc3iYWALgbdWHIi9XyOrTM0',
    ]
];
