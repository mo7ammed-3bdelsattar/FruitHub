<?php

namespace App\Models;

use App\Models\Address;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'about_us',
        'why_us',
        'goal',
        'vision',
        'tax_percentage',
        'shipping_fees',
        'welcome_text',
        'home_text',
        'success_text',
        'contact_us_text',
        'terms_text',
        'phone1',
        'phone2',
        'email',
        'facebook',
        'linkedin',
        'instagram',
        'youtube',
        'twitter',
        'pagination',
        'map',
    ];

    public function address()
    {
        return $this->hasMany(Address::class);
    }
}
