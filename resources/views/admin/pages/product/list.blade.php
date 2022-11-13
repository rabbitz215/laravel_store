@extends('admin.layouts.dashboard')

@section('content')
    <table id="data_products_reguler" class="display" style="width:100%">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Stock</th>
                <th scope="col">Status</th>
                <th scope="col">Category</th>
                <th scope="col">Image</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td><img src="/storage/{{ $item->image }}" width="150" alt=""></td>
                    <td>
                        <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data"
                            class="d-inline">
                            @csrf
                            <input type="hidden" value="{{ $item->id }}" name="id">
                            <input type="hidden" value="{{ $item->name }}" name="name">
                            <input type="hidden" value="{{ $item->price }}" name="price">
                            <input type="hidden" value="{{ $item->image }}" name="image">
                            <input type="hidden" value="1" name="quantity">
                            <button class="btn btn-warning rounded">Add To Cart</button>
                        </form>
                        <a href="{{ route('product.edit', ['product' => $item->slug]) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('product.destroy', ['product' => $item->slug]) }}" class="d-inline"
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
            $('#data_products_reguler').DataTable();
        });
    </script>
@endsection
