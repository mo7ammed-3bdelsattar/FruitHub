<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{



    public function __invoke(Request $request)
    {

        $searchProducts = app(Pipeline::class)
            ->send(Product::query())
            ->through([
                \App\Filters\Products\SearchFilter::class,
            ])
            ->thenReturn()
            ->latest()
            ->paginate(5);
        $searchOrders = app(Pipeline::class)
            ->send(Order::query())
            ->through([
                \App\Filters\Orders\SearchFilter::class,
            ])
            ->thenReturn()
            ->latest()
            ->paginate(5);
            
            if(count($searchProducts) > 0) $searchFlag = true;
            else $searchFlag = false;

            switch($searchFlag)
            {
                case true : 
                    return to_route("dashboard.products.index",$request->query());
                case false :
                    return to_route("dashboard.orders.index",$request->query());
            }
            
            

            
        // $searchResults = $searchProducts ?? ($searchOrders ?? false);
        // return redirect()->back()
    }
}
