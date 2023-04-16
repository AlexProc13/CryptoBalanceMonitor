<?php

namespace App\Servises\Wallets\BTC;

use App\Servises\Wallets\ETH\ETHSource;
use App\Servises\Wallets\ETH\ETHWalletTrait;
use App\Servises\Wallets\Source;
use Exception;
use App\Models\HistoryBalance;
use App\Servises\Wallets\Wallet;
use Illuminate\Support\Collection;
use App\Models\Wallet as WalletModel;

class BTCWallet extends Wallet
{

    public function isAddress(string $address): bool
    {
        return true;
    }

    public function getSource(): Source
    {
        return new BTCSource();
    }
}
