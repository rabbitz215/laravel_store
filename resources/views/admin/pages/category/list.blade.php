@extends('admin.layouts.dashboard')

@section('content')
    <table id="data_categories_reguler" class="display" style="width:100%">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['description'] }}</td>
                    <td>
                        <a href="{{ route('category.show', ['category' => $item->slug]) }}" class="btn btn-warning">List
                            Products</a>
                        <a href="{{ route('category.edit', ['category' => $item->slug]) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('category.destroy', ['category' => $item->slug]) }}" class="d-inline"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $('#data_categories_reguler').DataTable();
        });
    </script>
@endsection
