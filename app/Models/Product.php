<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image',
        'user_id',
    ];

    public function users()
    {
        // return $this->belongsTo(User::class);
        return $this->belongsTo('App\Models\User', 'user_id')->select('id','fullname','avatar');
    }

}
