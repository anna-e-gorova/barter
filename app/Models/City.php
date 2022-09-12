<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
