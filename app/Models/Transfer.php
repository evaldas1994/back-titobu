<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Transfer extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    const TABLE_NAME = 'transfers';

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        'name',
        'amount',
        'category_id',
        'account_id',
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function account()
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }
}
