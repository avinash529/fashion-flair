<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getCart(): array
    {
        return session('cart', []);
    }

    private function saveCart(array $cart): void
    {
        session(['cart' => $cart]);
    }

    public function index()
    {
        $cart = $this->getCart();
        $items = [];
        $total = 0;

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
            $total += $price * $item['quantity'];
        }

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        if (!$product->is_active || !$product->inStock()) {
            return back()->with('error', 'This product is currently unavailable.');
        }

        $cart = $this->getCart();
        $size = trim($request->input('size', ''));
        $color = trim($request->input('color', ''));
        $key = $product->id . '_' . $size . '_' . $color;
        $quantity = min((int) $request->input('quantity', 1), $product->stock_qty);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = min($cart[$key]['quantity'] + $quantity, $product->stock_qty);
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'size' => $size,
                'color' => $color,
            ];
        }

        $this->saveCart($cart);

        return back()->with('success', '"' . $product->name . '" added to your bag.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->getCart();

        if (isset($cart[$request->key])) {
            $product = Product::find($cart[$request->key]['product_id']);
            $cart[$request->key]['quantity'] = $product
                ? min($request->integer('quantity'), max(1, $product->stock_qty))
                : $request->integer('quantity');
            $this->saveCart($cart);
        }

        return back()->with('success', 'Cart updated.');
    }

    public function remove(Request $request)
    {
        $request->validate(['key' => 'required|string']);

        $cart = $this->getCart();

        if (isset($cart[$request->key])) {
            unset($cart[$request->key]);
        }

        $this->saveCart($cart);

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        session()->forget('cart');

        return back()->with('success', 'Cart cleared.');
    }

    public static function cartCount(): int
    {
        $cart = session('cart', []);

        return array_sum(array_column($cart, 'quantity'));
    }
}
