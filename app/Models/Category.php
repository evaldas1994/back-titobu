<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Category extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    const TABLE_NAME = 'categories';

    const TYPE_IN = 'incomes';
    const TYPE_OUT = 'expenses';

    static function getTypes()
    {
        return [
            self::TYPE_IN,
            self::TYPE_OUT,
        ];
    }

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        'name',
        'balance',
        'type',
        'account_id',
        'user_id',
        'purpose_id',
    ];

    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'category_id', 'id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function purpose()
    {
        return $this->hasOne(Purpose::class, 'id', 'purpose_id');
    }
}
