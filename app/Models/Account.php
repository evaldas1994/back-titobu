<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Account extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const TABLE_NAME = 'accounts';

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        'name',
        'user_id',
        'balance',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'account_id', 'id');
    }
}
