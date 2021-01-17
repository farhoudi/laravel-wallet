<?php

namespace Farhoudi\Wallet;

use Illuminate\Database\Eloquent\Collection;

/**
 * Trait HasWallet
 * @package Farhoudi\Wallet
 * @property float balance
 */
trait HasWallet
{

    public function hasEnoughBalance(float $amount): bool {
        return $this->balance - $amount >= 0;
    }

}
