<?php

namespace App\Servises\Wallets\ETH;

use App\Servises\Wallets\Source;
use Exception;
use App\Models\HistoryBalance;
use App\Servises\Wallets\Wallet;
use Illuminate\Support\Collection;
use App\Models\Wallet as WalletModel;

class ETHWallet extends Wallet
{
    use ETHWalletTrait;

    public function toCurrency($params): string
    {
        return 1;
    }

    public function isAddress(string $address): bool
    {
        //See: https://github.com/ethereum/web3.js/blob/7935e5f/lib/utils/utils.js#L415
        if ($this->matchesPattern($address)) {
            return $this->isAllSameCaps($address) ?: $this->isValidChecksum($address);
        }

        return false;
    }

    public function getSource(): Source
    {
        return new ETHSource();
    }
}
