@extends('admin.layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h1>{{ $product->id ? 'Edit Data' : 'Create Data' }}</h1>
                        @if ($product->id)
                            <form action="{{ route('product.update', ['product' => $product->slug]) }}" method="POST"
                                enctype="multipart/form-data">
                                @method('PUT')
                            @else
                                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @endif
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $product->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Description</label>
                            <textarea name="description" class="form-control" cols="30" rows="10">{{ $product->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Category</label>
                            <select name="category_id" class="form-select">
                                @foreach ($category as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $item->id == $product->category_id ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Category</label>
                            <select name="status" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" value="{{ $product->price }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Stock</label>
                            <input type="number" class="form-control" name="stock" value="{{ $product->stock }}">
                        </div>
                        @if ($product->image)
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Image</label> <br>
                                <img src="/storage/{{ $product->image }}" width="200" alt=""
                                    class="mb-3 img-thumbnail">
                                <input type="file" class="form-control" name="image">
                            </div>
                        @else
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Image</label>
                                <input type="file" class="form-control" name="image">
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('product.index') }}" class="btn btn-danger">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
