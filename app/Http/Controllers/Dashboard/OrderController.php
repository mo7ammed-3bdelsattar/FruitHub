<?php

namespace App\Http\Controllers\Dashboard;

use PDOException;
use App\Models\User;
use App\Models\Order;
use App\Models\Driver;
use App\Mail\OrderMail;
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
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('view orders'), 403);
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
        $order = OrderService::create($request->all());
        if (!$order) {
            return redirect()->back()->with('error', 'there an error happind');
        }
        return to_route('dashboard.orders.invoice', $order->id)->with('success', 'order taken successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(!auth()->user()->can('edit orders'), 403);
        $order = Order::with(['user', 'products'])->findOrFail($id);
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
        if ($request->payment_method == 'online') {
            return OrderService::orderPayment($order);
        }
        $data = $request->validate([
            'driver_id' => 'nullable|exists:drivers,id',
            'payment_status' => 'nullable|in:paid,pending,failed',
        ]);
        $order->update($data);
        return to_route('dashboard.orders.index')->with('success', 'Order Updated successfully!');
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
        if ($order->status == 'delivering') Mail::to($order->user->email)->send(new OrderMail($order, 'Your Order has been delivering'));
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
