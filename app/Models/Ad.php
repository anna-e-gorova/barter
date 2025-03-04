<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    public function Category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function User()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function City()
    {
        return $this->belongsTo(City::class,'city_id','id');
    }

}
