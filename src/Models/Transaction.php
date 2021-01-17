<?php

namespace App\Models;

use App\Constants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{

    protected $fillable = ['user_id', 'amount', 'type', 'method', 'source', 'status', 'gateway', 'description', 'callback_url', 'meta'];

    protected $casts = [
        'meta' => 'array',
    ];

    const INITIAL = 1;
    const FAILED = 2;
    const SUCCEEDED = 3;
    const STATUSES = [
        self::INITIAL => 'initial',
        self::FAILED => 'failed',
        self::SUCCEEDED => 'succeeded',
    ];

    const INCREMENT = 1;
    const DECREMENT = 2;
    const TYPES = [
        self::INCREMENT => 'increment',
        self::DECREMENT => 'decrement',
    ];

    const ONLINE = 1;
    const CASH = 2;
    const METHODS = [
        self::ONLINE => 'online',
        self::CASH => 'cash',
    ];

    protected $appends = [
        'status_display',
        'type_display',
        'method_display',
        'source_display',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getStatusDisplayAttribute() {
        return self::STATUSES[$this->status];
    }

    public function getTypeDisplayAttribute() {
        return self::TYPES[$this->type];
    }

    public function getMethodDisplayAttribute() {
        return self::METHODS[$this->method];
    }

    public function getSourceDisplayAttribute() {
        return Constants::TRANSACTION_SOURCES[$this->source];
    }

    public function getCreatedAtAttribute($value) {
        return app('jdate')->date('Y/m/d H:i:s', strtotime($value));
    }

    public static function initialIncrementTransaction($user, $amount, $source = null, $description = null, $gateway = null, $callbackUrl = null) {
        return self::submitTransaction($user, $amount, $source, $description, self::INCREMENT, self::INITIAL, $gateway, $callbackUrl);
    }

    public static function failedIncrementTransaction($user, $amount, $source = null, $description = null, $gateway = null, $callbackUrl = null) {
        return self::submitTransaction($user, $amount, $source, $description, self::INCREMENT, self::FAILED, $gateway, $callbackUrl);
    }

    public static function succeededIncrementTransaction($user, $amount, $source = null, $description = null, $gateway = null, $callbackUrl = null) {
        return self::submitTransaction($user, $amount, $source, $description, self::INCREMENT, self::SUCCEEDED, $gateway, $callbackUrl);
    }

    public static function initialDecrementTransaction($user, $amount, $source = null, $description = null, $gateway = null, $callbackUrl = null) {
        return self::submitTransaction($user, $amount, $source, $description, self::DECREMENT, self::INITIAL, $gateway, $callbackUrl);
    }

    public static function failedDecrementTransaction($user, $amount, $source = null, $description = null, $gateway = null, $callbackUrl = null) {
        return self::submitTransaction($user, $amount, $source, $description, self::DECREMENT, self::FAILED, $gateway, $callbackUrl);
    }

    public static function succeededDecrementTransaction($user, $amount, $source = null, $description = null, $gateway = null, $callbackUrl = null) {
        return self::submitTransaction($user, $amount, $source, $description, self::DECREMENT, self::SUCCEEDED, $gateway, $callbackUrl);
    }

    public static function submitTransaction($user, $amount, $source, $description, $type, $status, $gateway, $callbackUrl) {
        if ($type == self::INCREMENT) {
            $newCredit = $user->credit + $amount;
        } else { // decrement
            $newCredit = $user->credit - $amount;
        }
        $user->update(['credit' => $newCredit]);
        return Transaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'source' => $source,
            'type' => $type,
            'status' => $status,
            'method' => self::ONLINE,
            'description' => $description,
            'gateway' => $gateway,
            'callback_url' => $callbackUrl,
        ]);
    }

    public function updateMeta($meta) {
        return $this->update(['meta' => ($this->meta ?? []) + $meta,]);
    }

    public function succeeded() {
        return $this->update(['status' => self::SUCCEEDED]);
    }

    public function failed() {
        return $this->update(['status' => self::FAILED]);
    }

    public function getAmountAttribute($value) {
        return (int)$value;
    }

}
