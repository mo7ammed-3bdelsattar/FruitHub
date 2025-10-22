<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Cart;
use App\Models\Image;
use App\Models\Order;
use App\Models\Category;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'discount',
        'category_id',
    ];


    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity')->withTimestamps();
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_product')->withPivot('id', 'quantity')->withTimestamps();
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, "product_tag");
    }

    public function wishlists()
    {
        return $this->belongsToMany(Wishlist::class, 'product_wishlist')->withTimestamps();
    }

    public function scopeAdvancedFilter(Builder $query, array $filters)
    {
        return $query
            ->when(!empty($filters['search']), function ($q) use ($filters) {
                $q->with(['image', 'category'])->whereAny(['title', 'description'], 'like', "%$filters[search]%");
            })
            ->when(!empty($filters['category']), function ($q) use ($filters) {
                $q->whereHas('category', function ($qu) use ($filters) {
                    $qu->whereAny(['categories.id','categories.name'], $filters['category']);
                });
            })
            ->when(!empty($filters['tag']), function ($q) use ($filters) {
                $q->whereHas('tags', function ($qu) use ($filters) {
                    $qu->whereAny(['tags.id','name'], $filters['tag']);
                });
            })
            ->when(!empty($filters['minPrice']), function ($q) use ($filters) {
                $q->with(['image', 'category'])->where('price', '>=', $filters['minPrice']);
            })
            ->when(!empty($filters['maxPrice']), function ($q) use ($filters) {
                $q->with(['image', 'category'])->where('price', '<=', $filters['maxPrice']);
            });
    }


}
