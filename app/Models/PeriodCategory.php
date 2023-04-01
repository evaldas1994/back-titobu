<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class PeriodCategory extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    const TABLE_NAME = 'period_categories';

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        'limit',
        'period_id',
        'category_id',
        'user_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function period()
    {
        return $this->hasOne(Period::class, 'id', 'period_id');
    }
}
