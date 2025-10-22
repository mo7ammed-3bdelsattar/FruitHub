<?php

namespace App\Models;

use App\Models\Address;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'shipping_cost',
    ];
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
