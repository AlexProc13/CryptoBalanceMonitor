<?php

namespace App\Servises\Wallets\BTC;

use App\Servises\Wallets\Source;
use App\Servises\Wallets\Wallet;

class BTCWallet extends Wallet
{
    public function isAddress(string $address): bool
    {
        //todo use other way
        preg_match('/^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$/', $address, $matches);
        if (empty($matches)) {
            return false;
        }
        return true;
    }

    public function getSource(): Source
    {
        return new BTCSource();
    }
}
