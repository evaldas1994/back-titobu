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
    const TYPE_SAVINGS = 'savings';

    static function getTypes()
    {
        return [
            self::TYPE_IN,
            self::TYPE_OUT,
            self::TYPE_SAVINGS,
        ];
    }

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        'name',
        'type',
        'icon',
        'color',
        'user_id',
    ];

    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'category_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
