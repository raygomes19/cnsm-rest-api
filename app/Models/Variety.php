<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variety extends Model
{
    use HasFactory;

    // protected $fillable = ['quality', 'stock', 'price'];
    protected $guarded = ['brand_id', 'location_id'];

}
