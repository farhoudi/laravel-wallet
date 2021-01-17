<?php

namespace Farhoudi\Wallet\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

/**
 * Class Wallet
 * @package Farhoudi\Wallet\Models
 */
class Wallet extends Model {

    public $table = 'wallet_wallets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'balance',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'balance' => 'double',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'integer|exists:users,id',
        'balance' => 'double',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
