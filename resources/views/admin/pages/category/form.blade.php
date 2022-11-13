@extends('admin.layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h1>{{ $category->id ? 'Edit Data' : 'Create Data' }}</h1>
                        @if ($category->id)
                            <form action="{{ route('category.update', ['category' => $category->slug]) }}" method="POST">
                                @method('PUT')
                            @else
                                <form action="{{ route('category.store') }}" method="POST">
                        @endif
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Category Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $category->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Description</label>
                            <textarea name="description" class="form-control" cols="30" rows="10">{{ $category->description }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('category.index') }}" class="btn btn-danger">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
