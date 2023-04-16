<?php

namespace App\Servises\Wallets\Clients;

class BlockchairClient extends Client
{
    public function __construct()
    {
        $this->setUrl('https://api.blockchair.com/%s/addresses/balances?addresses=%s');
    }
}
