<?php

namespace App\Http\Controllers\Dashboard;

use PDOException;
use App\Models\User;
use App\Models\Order;
use App\Models\Driver;
use App\Models\Address;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\OrderTracking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use App\Http\Services\OrderService;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('view orders'), 403);
        $orders = Order::with(['products', 'user', 'driver'])->paginate(15);
        $request->validate([
            'search' => 'nullable|string|max:255'
        ]);
        $orders = app(Pipeline::class)
            ->send(Order::query())
            ->through(
                [
                    \App\Filters\Orders\SearchFilter::class,
                    \App\Filters\Orders\DateRangeFilter::class,
                    \App\Filters\Orders\StatusFilter::class,
                ]
            )
            ->thenReturn()
            ->with(['user', 'products', 'driver'])
            ->orderByRaw("FIELD(status ,'taken','preparing','delivering','received')")
            ->paginate(session('pagination'));
        return view('dashboard.pages.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->can('create orders'), 403);
        $categories = Category::with(['products'])->get();
        return view('dashboard.pages.orders.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        abort_if(!auth()->user()->can('create orders'), 403);
        $cartData = $request->all();
        $address = Address::find($cartData['address_id']);
        $cartData['total_price'] = $cartData['subtotal_price'] + $address->city->shipping_cost;
        $order = OrderService::create($cartData);
        if (!$order) {
            return redirect()->back()->with('error', 'there an error happind');
        }
        return to_route('dashboard.orders.invoice', $order->id)->with('success', 'order taken successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        abort_if(!auth()->user()->can('edit orders'), 403);
        $drivers = Driver::all();
        return view('dashboard.pages.orders.edit', compact('order', 'drivers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(!auth()->user()->can('edit orders'), 403);
        $order = Order::findOrFail($id);
        if ($request->filled('status') && $this->addStatus($request, $order)) {
            return redirect()->back()->with('success', 'Status add successfully!');
        }
        $data = $request->validate([
            'driver_id' => 'nullable|exists:drivers,id'
        ]);
        $order->update($data);
        return redirect()->back()->with('success', 'Order Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        abort_if(!auth()->user()->can('delete orders'), 403);
        $order->delete();
        return redirect()->route('dashboard.orders.index')->with('success', 'order removed successfully');
    }

    private function addStatus($request, $order)
    {
        abort_if(!auth()->user()->can('edit orders'), 403);
        $request->validate([
            'status' => 'required|in:taken,preparing,delivering,received,cancelled',
        ]);
        $order->orderTrackings()->create(['status' => $request->input('status')]);
        $order->update(['status' => $request->input('status')]);
        return true;
    }

    public function invoice(string $id)
    {
        abort_if(!auth()->user()->can('view orders'), 403);
        $order = Order::with(['products'])->findOrFail($id);

        return view('dashboard.pages.orders.invoice', compact('order'));
    }

    public function invoicePdf(string $id)
    {
        abort_if(!auth()->user()->can('view orders'), 403);
        $order = Order::with(['products'])->findOrFail($id);

        $pdf = Pdf::loadView('dashboard.pages.orders.invoice', compact('order'))
            ->setPaper('a4', 'portrait')
            ->setOption('margin-top', 10)
            ->setOption('margin-bottom', 10);

        return $pdf->download('invoice_' . $order->order_number . '.pdf');
    }
    public function deleteItem(string $orderId, string $productId)
    {
        abort_if(!auth()->user()->can('view orders'), 403);
        $order = Order::findOrFail($orderId);
        $product = Product::findOrFail($productId);

        if ($order->products()->count() === 1) {
            $order->products()->detach($product->id);
            $order->delete();
            return redirect()->route('dashboard.orders.index')->with('success', 'Item deleted and order removed (was last item).');
        }

        $linePrice = $product->price * (1 - $product->discount / 100);
        $order->total_price -= $linePrice;
        $order->subtotal_price -= $linePrice;
        $order->save();

        $order->products()->detach($product->id);
        return redirect()->back()->with('success', 'Item deleted from order successfully');
    }
}
