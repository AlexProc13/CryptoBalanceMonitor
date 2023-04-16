<?php

return [
    'currencies' => [
       // 'BTC' => 1,
      //  'LTC' => 2,
        'ETH' => 3,
        //...
    ],
    'walletProviders' => [
        'ETH' => \App\Servises\Wallets\ETH\ETHWallet::class,
        //...
    ],
    'sources' => [
        'ETH' => ['key' => env('SOURCE_ETH')]
        //...
    ],
];
