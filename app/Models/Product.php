<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable= [
        'title',
        'description',
        'imgUrl',
        'price',
        'quantityInStock',
        'categoryId'
    ];



    public function category()
    {
        return $this->belongsTo(Category::class,'categoryId','id');
    }

    public function scopeGetActive()
    {
        return $this->where('quantityInStock','>=',1);
    }
}
