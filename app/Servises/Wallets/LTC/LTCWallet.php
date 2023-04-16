<?php

namespace App\Servises\Wallets\LTC;

use App\Servises\Wallets\Source;
use App\Servises\Wallets\Wallet;

class LTCWallet extends Wallet
{
    public function isAddress(string $address): bool
    {
        //todo use other way
        preg_match('/^[LM3][a-km-zA-HJ-NP-Z1-9]{26,33}$/', $address, $matches);
        if (empty($matches)) {
            return true;
        }
        return true;
    }

    public function getSource(): Source
    {
        return new LTCSource();
    }
}
