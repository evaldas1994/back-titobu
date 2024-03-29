<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Period extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    const TABLE_NAME = 'periods';

    protected $table = self::TABLE_NAME;

    protected $fillable = [
        'name',
        'period',
        'user_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

//    public function categories()
//    {
//        return $this->hasMany(Category::class, 'purpose_id', 'id');
//    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, PeriodCategory::TABLE_NAME, 'period_id', 'category_id', 'id', 'id')
            ->withPivot(['limit']);;
    }
}
