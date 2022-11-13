@extends('layouts.dashboard')

@section('checkout')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <div class="card">
                            <div class="card-header">
                                Products
                            </div>

                            <div class="card-body">
                                <table class="table" id="products_table">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartItems as $item)
                                            <tr>
                                                <td>
                                                    <img src="/storage/{{ $item->attributes->image }}" width="100"
                                                        alt="">
                                                </td>
                                                <td>
                                                    {{ $item->name }}
                                                </td>
                                                <td>
                                                    Rp.{{ number_format($item->price, 2) }}
                                                </td>
                                                <td>
                                                    <form action="{{ route('checkout.update') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                                        <input type="number" min="1" name="quantity"
                                                            value="{{ $item->quantity }}" class="form-control" />
                                                        <button type="submit" class="btn btn-primary mt-1">Update</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form action="{{ route('checkout.remove') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" value="{{ $item->id }}" name="id">
                                                        <button class="btn btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                Total: Rp.{{ number_format(Cart::getTotal(), 2) }}
                            </div>
                        </div>
                        <br>
                        <div>
                            @if ($balance <= Cart::getTotal())
                                <button class="btn btn-danger disabled">Not Enough Balance</button>
                            @else
                                <form action="{{ route('checkout.db') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-primary">Save Order</button>
                                </form>
                            @endif
                            <form action="{{ route('checkout.clear') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-danger">Remove All Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
