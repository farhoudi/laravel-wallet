<?php

namespace Farhoudi\Wallet;

use Illuminate\Support\ServiceProvider;

class WalletServiceProvider extends ServiceProvider {

    public function register() {
        //
    }

    public function boot() {
        $this->publishes([
            __DIR__.'/migrations/' => database_path('migrations')
        ], 'migrations');
    }

}
