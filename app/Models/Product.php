<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'detail','created_by','image'
    ];

    public function getImageAttribute($value) {
        if($value) {
            return asset('storage/').'/'.$value;
        }else {
            return 'no Image';
        }
    }
}