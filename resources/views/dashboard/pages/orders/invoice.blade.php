<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Invoice Number ') . $order->order_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                padding: 0;
                background: #fff;
            }

            .invoice {
                box-shadow: none;
                max-width: 100%;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            background: #f6f6f6;
            padding: 20px;
        }

        .invoice {
            background: #fff;
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.15);
        }

        .invoice-header {
            text-align: center;
            border-bottom: 2px dashed #ccc;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .invoice-header img {
            width: 80px;
            margin-bottom: 10px;
        }

        .invoice-header h2 {
            margin: 5px 0;
            color: #333;
            font-size: 24px;
        }

        .badge {
            display: inline-block;
            background-color: #000;
            color: #fff;
            padding: 5px 12px;
            border-radius: 5px;
            font-size: 12px;
            margin-top: 8px;
        }

        .invoice-info {
            margin: 15px 0;
            font-size: 14px;
            line-height: 1.8;
        }

        .invoice-info p {
            margin: 5px 0;
            display: flex;
            justify-content: space-between;
        }

        .invoice-info strong {
            color: #555;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin: 15px 0;
        }

        .invoice-table th {
            background-color: #f0f0f0;
            padding: 8px 4px;
            text-align: center;
            border-bottom: 2px solid #ddd;
            font-weight: 600;
        }

        .invoice-table td {
            text-align: center;
            padding: 8px 4px;
            border-bottom: 1px dashed #ddd;
        }

        .invoice-table tbody tr:last-child td {
            border-bottom: none;
        }

        .invoice-total {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 2px dashed #ccc;
        }

        .invoice-total .row {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            font-size: 14px;
        }

        .invoice-total .total-final {
            background-color: #000;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
            font-weight: 700;
            margin-top: 10px;
        }

        .thank-you {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px dashed #ccc;
            font-size: 13px;
            color: #555;
        }

        .thank-you p {
            margin: 5px 0;
        }

        /* Action Buttons */
        .action-buttons {
            text-align: center;
            margin: 20px auto;
            max-width: 400px;
        }

        .btn {
            display: inline-block;
            margin: 5px;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-print {
            background: #4CAF50;
            color: white;
        }

        .btn-print:hover {
            background: #45a049;
        }

        .btn-download {
            background: #2196F3;
            color: white;
        }

        .btn-download:hover {
            background: #0b7dda;
        }

        .btn-back {
            background: #666;
            color: white;
        }

        .btn-back:hover {
            background: #555;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <!-- Action Buttons (Hidden when printing) -->
    <div class="action-buttons no-print">
        <button onclick="window.print()" class="btn btn-print">
            🖨️ {{ __('Print Invoice') }}
        </button>
        <a href="{{ route('dashboard.orders.invoice.pdf', $order->id) }}" class="btn btn-download">
            📥 {{ __('Download PDF') }}
        </a>
        <a href="{{ route('dashboard.orders.index') }}" class="btn btn-back">
            ← {{ __('Back to Orders') }}
        </a>
    </div>

    <div class="invoice">
        <!-- Header -->
        <div class="invoice-header">

            <h2> {{ __('Fruit Hub') }}</h2>
            <span class="badge">
                {{ __('Invoice Number: ') . $order->order_number }}
            </span>
        </div>

        <!-- Customer & Order Info -->
        <div class="invoice-info">
            <p>
                <strong>{{ __('Client Name:') }}</strong>
                <span>{{ $order->user->name }}</span>
            </p>
            <p>
                <strong>{{ __('Phone:') }}</strong>
                <span>{{ $order->user->phone ?? 'N/A' }}</span>
            </p>
            <p>
                <strong>{{ __('Order Date:') }}</strong>
                <span>{{ $order->created_at->format('Y-m-d h:i A') }}</span>
            </p>
            @if($order->address)
            <p>
                <strong>{{ __('Delivery Address:') }}</strong>
                <span>{{ $order->address->city->name ?? '' }}</span>
            </p>
            @endif
        </div>

        <!-- Products Table -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>{{ __('Product') }}</th>
                    <th>{{ __('Qty') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Disc.') }}</th>
                    <th>{{ __('Total') }}</th>
                </tr>
            </thead>
            <tbody>
                @php $subtotal = 0; @endphp
                @foreach($order->products as $item)
                @php
                    $priceAfterDiscount = $item->price * (1 - $item->discount / 100);
                    $itemTotal = $priceAfterDiscount * $item->pivot->quantity;
                    $subtotal += $itemTotal;
                @endphp
                <tr>
                    <td style="text-align: right;">{{ $item->title }}</td>
                    <td>{{ $item->pivot->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->discount }}%</td>
                    <td>{{ number_format($itemTotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals Section -->
        <div class="invoice-total">
            <div class="row">
                <span>{{ __('Subtotal:') }}</span>
                <strong>{{ number_format($subtotal, 2) }} {{ __('LE') }}</strong>
            </div>
            <div class="row">
                <span>{{ __('Shipping Cost:') }}</span>
                <strong>{{ number_format($order->address->city->shipping_cost ?? 0, 2) }} {{ __('LE') }}</strong>
            </div>
            <div class="total-final">
                {{ __('Total: ') }} {{ number_format($order->total_price, 2) }} {{ __('LE') }}
            </div>
        </div>

        <!-- Thank You Message -->
        <div class="thank-you">
            <p><strong>{{ __('Thank you for your purchase!') }}</strong></p>
            <p>{{ __('We appreciate your business') }}</p>
            <p>{{ __('See you soon') }}</p>
        </div>
    </div>

    <!-- Auto-print script (Optional - Uncomment to enable) -->
    <!--
    <script>
        // Auto-print when page loads
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 500);
        });
    </script>
    -->
</body>

</html>

