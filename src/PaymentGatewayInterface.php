<?php

namespace Farhoudi\Wallet;

use Farhoudi\Wallet\Models\Transaction;
use Illuminate\Http\Request;

abstract class PaymentGatewayInterface {

    public string $displayName;

    abstract public function startResponse(Transaction $transaction);

    abstract public function callbackProcessResponse(Transaction $transaction, Request $request);

}
