@extends('admin.layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detail as $item)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td><img src="/storage/{{ $item->product->image }}" width="100" alt="">
                                        </td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>Rp.{{ number_format($item->amount, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('transaction.index') }}" class="btn btn-danger">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
