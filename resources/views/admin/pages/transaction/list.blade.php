@extends('admin.layouts.dashboard')

@section('content')
    <table id="data_transactions_reguler" class="display" style="width:100%">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Transaction ID</th>
                <th scope="col">Customer</th>
                <th scope="col">Total Amount</th>
                <th scope="col">Transaction Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->customer }}</td>
                    <td>Rp.{{ number_format($item->total_amount, 2) }}</td>
                    <td>{{ date_format($item->created_at, 'd M Y') }}<br>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                    </td>
                    <td>
                        <a href="{{ route('transaction.show', ['transaction' => $item->id]) }}"
                            class="btn btn-warning">Details</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $('#data_transactions_reguler').DataTable();
        });
    </script>
@endsection
