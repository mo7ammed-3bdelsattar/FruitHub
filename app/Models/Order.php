<?php

namespace App\Models;

use App\Models\User;
use App\Models\Driver;
use App\Models\Address;
use App\Models\Product;
use App\Models\OrderTracking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'address_id',
        'total_price',
        'status',
        'driver_id',
        'subtotal_price'
    ];


    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity')->withTimestamps();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function driver()
    {
        return $this->belongsTo(Driver::class );
    }

    public function orderTrackings()
    {
        return $this->hasMany(OrderTracking::class);
    }
    public function address(){
        return $this->belongsTo(Address::class);
    }
    
    public function getAddress()
    {
        return $this->address->city->name . "/" . $this->address->street . '/' . $this->address->building ;
    }
}
