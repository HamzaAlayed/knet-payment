<?php

return [
    'production_url'    => env('KENT_PRODUCTION_URL', 'https://kpay.com.kw/kpg/PaymentHTTP.htm'),
    'development_url'   => env('KENT_PRODUCTION_URL', 'https://kpaytest.com.kw/kpg/PaymentHTTP.htm'),
    'transport_id'      => env('KENT_TRANSPORT_ID'),
    'transport_password'=> env('KENT_TRANSPORT_PASSWORD'),
    'response_url'      => url('/knet'),
    'error_url'         => url('/knet'),
    'action_code'       => env('KENT_ACTION_CODE', 1),
    'resource_key'      => env('KENT_RESOURCE_KEY'),
    'language'          => env('KENT_LANGUAGE', 'USA'),
    'currency'          => env('KENT_CURRENCY', 414),
];
