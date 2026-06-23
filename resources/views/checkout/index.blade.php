@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<section class="section-tight section-band">
    <div class="container">
        <div class="section-header">
            <div>
                <div class="eyebrow">Checkout</div>
                <h1 class="section-title">Delivery details</h1>
            </div>
            <a href="{{ route('cart.index') }}" class="btn-secondary">Back to Bag</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf

            <div class="lg:col-span-2 space-y-6 reveal-left">
                @if($addresses->count() > 0)
                    <div class="panel">
                        <h2 class="panel-title">Saved addresses</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($addresses as $address)
                                <label class="address-option">
                                    <input type="radio" name="address_id" value="{{ $address->id }}" {{ old('address_id', $loop->first ? $address->id : null) == $address->id ? 'checked' : '' }}>
                                    <span class="font-bold ml-2">{{ $address->name }}</span>
                                    <span class="block text-sm text-gray-600 mt-2">
                                        {{ $address->line1 }}{{ $address->line2 ? ', ' . $address->line2 : '' }},
                                        {{ $address->city }}, {{ $address->state }} {{ $address->pincode }}
                                    </span>
                                    <span class="block text-sm text-gray-600">{{ $address->phone }}</span>
                                </label>
                            @endforeach
                            <label class="address-option">
                                <input type="radio" name="address_id" value="" {{ old('address_id') === '' ? 'checked' : '' }}>
                                <span class="font-bold ml-2">Use a new address</span>
                                <span class="block text-sm text-gray-600 mt-2">Fill the shipping fields below.</span>
                            </label>
                        </div>
                    </div>
                @endif

                <div class="panel">
                    <h2 class="panel-title">{{ $addresses->count() > 0 ? 'Use a new address' : 'Shipping address' }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="field-group">
                            <label for="name">Full name</label>
                            <input id="name" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" {{ $addresses->count() ? '' : 'required' }}>
                            @error('name') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="field-group">
                            <label for="phone">Phone</label>
                            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" {{ $addresses->count() ? '' : 'required' }}>
                            @error('phone') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="field-group md:col-span-2">
                            <label for="line1">Address line 1</label>
                            <input id="line1" type="text" name="line1" value="{{ old('line1') }}" {{ $addresses->count() ? '' : 'required' }}>
                            @error('line1') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="field-group md:col-span-2">
                            <label for="line2">Address line 2</label>
                            <input id="line2" type="text" name="line2" value="{{ old('line2') }}">
                            @error('line2') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="field-group">
                            <label for="city">City</label>
                            <input id="city" type="text" name="city" value="{{ old('city') }}" {{ $addresses->count() ? '' : 'required' }}>
                            @error('city') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="field-group">
                            <label for="state">State</label>
                            <input id="state" type="text" name="state" value="{{ old('state') }}" {{ $addresses->count() ? '' : 'required' }}>
                            @error('state') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="field-group">
                            <label for="pincode">Pincode</label>
                            <input id="pincode" type="text" name="pincode" value="{{ old('pincode') }}" {{ $addresses->count() ? '' : 'required' }}>
                            @error('pincode') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="field-group flex items-center pt-7">
                            <label class="check-row">
                                <input type="checkbox" name="save_address" value="1" {{ old('save_address') ? 'checked' : '' }}>
                                <span>Save this address</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <h2 class="panel-title">Payment</h2>
                    <label class="address-option">
                        <input type="radio" name="payment_method" value="cod" checked>
                        <span class="font-bold ml-2">Cash on Delivery</span>
                        <span class="block text-sm text-gray-600 mt-2">Pay when your order arrives.</span>
                    </label>
                    @error('payment_method') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="panel">
                    <label for="notes">Order note</label>
                    <textarea id="notes" name="notes" placeholder="Optional">{{ old('notes') }}</textarea>
                    @error('notes') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <aside class="summary-panel panel reveal-right">
                <h2 class="panel-title">Order Summary</h2>

                <div class="space-y-4 mb-5">
                    @foreach($items as $item)
                        @php($product = $item['product'])
                        <div class="flex justify-between gap-4 pb-3 border-b border-gray-200">
                            <div>
                                <strong class="block">{{ $product->name }}</strong>
                                <span class="text-sm text-gray-600">Qty {{ $item['quantity'] }}</span>
                            </div>
                            <strong>Rs. {{ number_format($item['total_price'], 2) }}</strong>
                        </div>
                    @endforeach
                </div>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <strong>Rs. {{ number_format($subtotal, 2) }}</strong>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <strong>{{ $shipping === 0 ? 'Free' : 'Rs. ' . number_format($shipping, 2) }}</strong>
                </div>
                <div class="summary-total">
                    <strong>Total</strong>
                    <span>Rs. {{ number_format($total, 2) }}</span>
                </div>

                <button type="submit" class="btn-primary w-full mt-6">Place Order</button>
            </aside>
        </form>
    </div>
</section>
@endsection
