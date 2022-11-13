<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Category extends Authenticatable
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
    ];

    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'category_id', 'id');
    }
}
