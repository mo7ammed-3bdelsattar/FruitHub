<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        abort_if(!auth()->user()->can('view dashboard'), 403);
        $products = Product::withSum('orders as total_quantity_sold', 'order_product.quantity')->get()
            ->map(function ($product) {
                $product->total_revenue = $product->price * ($product->total_quantity_sold ?? 0);
                return $product;
            });
        $topProducts = $products->sortByDesc('total_quantity_sold')->values()->take(5);
        $countProducts = $products->count();


        $results = Order::selectRaw("
        status,
        COUNT(*) as total_orders,
        SUM(total_price) as total_revenue"
        )
        ->groupBy('status')->get();
        $orderStatusCount =$results->pluck('total_orders','status');
        $totalPrice = $results->pluck('total_revenue','status')['received'] ?? 0;
        $orderCount = $orderStatusCount['received'];
        $customerCount = User::role('customer')->count();

        return view('dashboard.pages.home.index', compact(['topProducts', 'orderStatusCount', 'customerCount', 'orderCount', 'totalPrice', 'countProducts']));
    }
}
