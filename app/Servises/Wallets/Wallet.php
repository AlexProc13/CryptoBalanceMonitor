<?php

namespace App\Servises\Wallets;

use App\Models\HistoryBalance;
use App\Servises\Wallets\ETH\ETHSource;
use Illuminate\Support\Collection;

abstract class Wallet
{
    abstract public function toCurrency($params);

    abstract public function getSource();

    public function updateBalances($wallets): bool
    {
        $addresses = $wallets->pluck('address')->toArray();
        $source = $this->getSource();
        $balancePerAddress = $source->getBalances($addresses);
        foreach ($wallets as $wallet) {
            if (!isset($balancePerAddress[$wallet->address])) {
                continue;
            }

            $balance = $wallet->lastBalance->balance;
            $currentBalance = $balancePerAddress[$wallet->address];
            if ($balance === $currentBalance) {
                continue;
            }
            HistoryBalance::create([
                'wallet_id' => $wallet->id,
                'balance' => $currentBalance
            ]);
        }
        return 1;
    }
}
