<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Account extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    const TABLE_NAME = 'accounts';

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        'name',
        'balance',
        'user_id',
    ];

    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'account_id', 'id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'account_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
