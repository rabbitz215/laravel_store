@extends('admin.layouts.dashboard')

@section('content')
    <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">
            <h1>Admin Page Info</h1>
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Total Users</th>
                        <th scope="col">Category</th>
                        <th scope="col">Products</th>
                        <th scope="col">Transactions</th>
                        <th scope="col">Total Income</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ \App\Models\User::get()->count() }}</td>
                        <td>{{ \App\Models\Category::get()->count() }}</td>
                        <td>{{ \App\Models\Product::get()->count() }}</td>
                        <td>{{ \App\Models\Transaction::get()->count() }}</td>
                        <td>Rp.{{ number_format(\App\Models\Transaction::get()->sum('total_amount'), 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
