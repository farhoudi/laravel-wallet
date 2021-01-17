# Laravel Wallet
Laravel Wallet (for Laravel 5+).

## Installation

Require via composer:

```
composer require farhoudi/laravel-wallet
```

Register service provider to the `providers` array in `config/app.php`

```php
Farhoudi\Wallet\WalletServiceProvider::class,
```

Publish migration files

```
$ php artisan vendor:publish --provider="Farhoudi\Wallet\WalletServiceProvider"
```

Run migrations

```
$ php artisan migrate
```

Add Wallet trait to your `User` model

```php
use Farhoudi\Wallet\HasWallet;
	
class User extends Authenticatable
{
    use HasWallet;
    ...
	    
}
```

## License

Laravel Wallet is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
