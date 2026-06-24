<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $items = [];
        $subtotal = 0;

        foreach ($cart as $key => $item) {
            $product = Product::find($item['product_id']);

            if (!$product) {
                continue;
            }

            $price = $product->discountedPrice();
            $items[$key] = array_merge($item, [
                'product' => $product,
                'unit_price' => $price,
                'total_price' => $price * $item['quantity'],
            ]);
            $subtotal += $price * $item['quantity'];
        }

        if (empty($items)) {
            session()->forget('cart');

            return redirect()->route('cart.index')->with('error', 'Your cart items are no longer available.');
        }

        $shipping = $subtotal >= 999 ? 0 : 99;
        $total = $subtotal + $shipping;
        $addresses = auth()->user()->addresses()->latest()->get();

        return view('checkout.index', compact('items', 'subtotal', 'shipping', 'total', 'addresses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'address_id' => 'nullable|integer',
            'payment_method' => 'required|in:cod',
            'save_address' => 'nullable|boolean',
            'notes' => 'nullable|string|max:500',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $address = null;

        if ($request->filled('address_id')) {
            $address = auth()->user()->addresses()->find($request->integer('address_id'));

            if (!$address) {
                return back()->with('error', 'Please choose a valid delivery address.')->withInput();
            }
        }

        if ($address) {
            $shippingData = [
                'name' => $address->name,
                'phone' => $address->phone,
                'line1' => $address->line1,
                'line2' => $address->line2,
                'city' => $address->city,
                'state' => $address->state,
                'pincode' => $address->pincode,
            ];
        } else {
            $shippingData = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'line1' => 'required|string|max:255',
                'line2' => 'nullable|string|max:255',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'pincode' => 'required|string|max:10',
            ]);
        }

        if (!$address && $request->boolean('save_address')) {
            auth()->user()->addresses()->create($shippingData);
        }

        try {
            $order = DB::transaction(function () use ($cart, $shippingData, $data) {
                $subtotal = 0;
                $orderItems = [];

                foreach ($cart as $item) {
                    $product = Product::lockForUpdate()->find($item['product_id']);

                    if (!$product || !$product->is_active) {
                        continue;
                    }

                    if ($product->stock_qty < $item['quantity']) {
                        throw new \RuntimeException($product->name . ' has only ' . $product->stock_qty . ' item(s) left.');
                    }

                    $price = $product->discountedPrice();
                    $subtotal += $price * $item['quantity'];
                    $orderItems[] = [
                        'product' => $product,
                        'payload' => [
                            'product_id' => $product->id,
                            'size' => $item['size'] ?? null,
                            'color' => $item['color'] ?? null,
                            'quantity' => $item['quantity'],
                            'unit_price' => $price,
                            'total_price' => $price * $item['quantity'],
                        ],
                    ];
                }

                if (empty($orderItems)) {
                    throw new \RuntimeException('Your cart does not contain available products.');
                }

                $shipping = $subtotal >= 999 ? 0 : 99;
                $total = $subtotal + $shipping;

                $order = Order::create([
                    'user_id' => auth()->id(),
                    'status' => 'pending',
                    'subtotal' => $subtotal,
                    'discount' => 0,
                    'shipping' => $shipping,
                    'total' => $total,
                    'payment_method' => $data['payment_method'],
                    'payment_status' => 'pending',
                    'ship_name' => $shippingData['name'],
                    'ship_phone' => $shippingData['phone'],
                    'ship_line1' => $shippingData['line1'],
                    'ship_line2' => $shippingData['line2'] ?? null,
                    'ship_city' => $shippingData['city'],
                    'ship_state' => $shippingData['state'],
                    'ship_pincode' => $shippingData['pincode'],
                    'notes' => $data['notes'] ?? null,
                ]);

                foreach ($orderItems as $item) {
                    $order->items()->create($item['payload']);
                    $item['product']->decrement('stock_qty', $item['payload']['quantity']);
                }

                OrderStatusHistory::create([
                    'order_id' => $order->id,
                    'status' => 'pending',
                    'note' => 'Order placed successfully.',
                ]);

                return $order;
            });
        } catch (\RuntimeException $exception) {
            return back()->with('error', $exception->getMessage())->withInput();
        }

        session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully.');
    }
}
