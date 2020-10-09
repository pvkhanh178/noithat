<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attributes extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'name',
        'description',
        'color',
        'size',
        'unit',
        'slug',
    ];
}
