<?php

namespace Farhoudi\Wallet;

use Illuminate\Database\Eloquent\Collection;

/**
 * Trait Wallet
 */
trait HasWallet
{

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }

    public function hasEnoughBalance(double $amount): bool {
        return $this->balance - $amount >= 0;
    }

}
