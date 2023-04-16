<?php

namespace App\Servises\Wallets\Clients;
class EtherscanClient extends Client
{
    public function __construct()
    {
        $this->setUrl('https://api.etherscan.io/api?module=%s&action=%s&address=%s&tag=latest&apikey=%s');
    }
}
