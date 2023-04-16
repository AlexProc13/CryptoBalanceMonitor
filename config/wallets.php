<?php

return [
    'currencies' => [
        'BTC' => 1,
        'LTC' => 2,
        'ETH' => 3,
        //...
    ],
    'walletProviders' => [
        'BTC' => \App\Servises\Wallets\Currencies\BTC\BTCWallet::class,
        'LTC' => \App\Servises\Wallets\Currencies\LTC\LTCWallet::class,
        'ETH' => \App\Servises\Wallets\Currencies\ETH\ETHWallet::class,
        //...
    ],
    'sources' => [
        'ETH' => ['key' => env('SOURCE_ETH')]
        //...
    ],
];
