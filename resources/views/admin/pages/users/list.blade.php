@extends('admin.layouts.dashboard')

@section('content')
    <table id="data_users_reguler" class="display" style="width:100%">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>Rp.{{ number_format($item->balance, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $('#data_users_reguler').DataTable();
        });
    </script>
@endsection
