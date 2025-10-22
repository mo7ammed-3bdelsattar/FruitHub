<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable=[
      "user_id"  
    ];

    public function user(){
        $this->belongsTo(User::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class,'product_wishlist')->withTimestamps();
    }
}
