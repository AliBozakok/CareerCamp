<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable=[
        'productId',
        'userId',
        'qty'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'productId','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'userId','id');
    }

    protected $appends= ['total'];

    public function getTotalAttribute()
    {
        return $this->qty * $this->product->price;
    }
}
