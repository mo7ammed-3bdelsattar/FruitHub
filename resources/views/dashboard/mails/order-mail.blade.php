<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Notification</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f4f7;
            padding: 20px;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #FFA500 0%, #FF6347 100%);
            color: #ffffff;
            padding: 40px 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .content {
            padding: 40px 30px;
        }

        .message-box {
            background-color: #FFF8F0;
            border-left: 4px solid #FFA500;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }

        .message-box h3 {
            color: #333333;
            font-size: 16px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .message-box p {
            color: #666666;
            font-size: 14px;
            line-height: 1.8;
        }

        .order-details {
            background-color: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin: 25px 0;
        }

        .order-details h2 {
            color: #333333;
            font-size: 20px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #666666;
            font-weight: 500;
            font-size: 14px;
        }

        .detail-value {
            color: #333333;
            font-weight: 600;
            font-size: 14px;
            text-align: right;
        }

        .order-items {
            margin: 25px 0;
        }

        .order-items h3 {
            color: #333333;
            font-size: 18px;
            margin-bottom: 15px;
        }

        .item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .item-info {
            flex: 1;
        }

        .item-name {
            color: #333333;
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 5px;
        }

        .item-details {
            color: #666666;
            font-size: 13px;
        }

        .item-price {
            color: #FF6347;
            font-weight: 700;
            font-size: 16px;
            margin-left: 15px;
        }

        .total-section {
            background: linear-gradient(135deg, #FFA500 0%, #FF6347 100%);
            color: #ffffff;
            padding: 20px 25px;
            border-radius: 8px;
            margin: 25px 0;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-label {
            font-size: 18px;
            font-weight: 600;
        }

        .total-amount {
            font-size: 24px;
            font-weight: 700;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #666666;
            font-size: 13px;
        }

        .footer p {
            margin: 5px 0;
        }

        .footer a {
            color: #FF6347;
            text-decoration: none;
        }

        .button {
            display: inline-block;
            background: linear-gradient(135deg, #FFA500 0%, #FF6347 100%);
            color: #ffffff;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
            transition: all 0.3s;
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 99, 71, 0.3);
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-processing {
            background-color: #cfe2ff;
            color: #084298;
        }

        .status-completed {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #842029;
        }

        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }

            .content {
                padding: 25px 20px;
            }

            .header {
                padding: 30px 20px;
            }

            .header h1 {
                font-size: 24px;
            }

            .detail-row {
                flex-direction: column;
                gap: 5px;
            }

            .detail-value {
                text-align: left;
            }

            .item {
                flex-direction: column;
                align-items: flex-start;
            }

            .item-price {
                margin-left: 0;
                margin-top: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>🍊 FruitHub Order</h1>
            <p>Fresh Fruits Delivered to Your Door!</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Greeting -->
            <p style="color: #333333; font-size: 16px; margin-bottom: 20px;">
                Hello <strong>{{ $order->user->name ?? 'Valued Customer' }}</strong>,
            </p>

            <!-- Custom Message -->
            @if($statusMessage)
            <div class="message-box">
                <p>{{ $statusMessage }}</p>
            </div>
            @endif

            <!-- Order Details -->
            <div class="order-details">
                <h2>Order Details</h2>

                <div class="detail-row">
                    <span class="detail-label">Order Number:</span>
                    <span class="detail-value">#{{ $order->order_number ?? $order->id }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Order Date:</span>
                    <span class="detail-value">{{ $order->created_at->format('M d, Y - h:i A') }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">
                        <span class="status-badge status-{{ strtolower($order->status ?? 'taken') }}">
                            {{ ucfirst($order->status ?? 'taken') }}
                        </span>
                    </span>
                </div>

                @if(isset($order->user->email))
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $order->user->email }}</span>
                </div>
                @endif

                @if(isset($order->user->phone))
                <div class="detail-row">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value">{{ $order->user->phone }}</span>
                </div>
                @endif

                @if(isset($order->address))
                <div class="detail-row">
                    <span class="detail-label">Shipping Address:</span>
                    <span class="detail-value">{{ $order->getAddress() }}</span>
                </div>
                @endif
            </div>

            <!-- Order Items -->
            @if(isset($order->products) && count($order->products) > 0)
            <div class="order-items">
                <h3>🛒 Your Fresh Fruits</h3>

                @foreach($order->products as $item)
                <div class="item">
                    <div class="item-info">
                        <div class="item-name">{{ $item->title ?? $item->name }}</div>
                        <div class="item-details">
                            Quantity: {{ $item->quantity }}
                            @if(isset($item->price))
                            × ${{ number_format($item->price, 2) }}
                            <div class="item-price">
                                ${{ number_format($item->price * $item->quantity, 2) }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Total -->
            @if(isset($order->total_price))
            <div class="total-section">
                <div class="total-row">
                    <span class="total-label">Total Amount:</span>
                    <span class="total-amount">${{ number_format($order->total_price, 2) }}</span>
                </div>
            </div>
            @endif



            <!-- Additional Information -->
            <p style="color: #666666; font-size: 14px; margin-top: 25px;">
                If you have any questions about your order, please don't hesitate to contact our support team.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>🍊 FruitHub</strong></p>
            <p>Your trusted source for fresh, quality fruits</p>
            <p>Email: <a href="mailto:support@fruithub.com">support@fruithub.com</a></p>
            <p>Phone: +1 (555) 123-4567</p>
            <p style="margin-top: 15px; color: #999999; font-size: 12px;">
                © {{ date('Y') }} FruitHub. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>