<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderTracking extends Model
{
    use HasFactory;

    protected $fillable =[
      'order_id',
      'status',  
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
