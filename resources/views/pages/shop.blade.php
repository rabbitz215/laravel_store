@extends('layouts.dashboard')

@section('filter')
    <form class="row g-3" action="{{ route('index') }}" method="GET">
        <div class="col-auto">
            <select name="filter" id="filter" class="form-select">
                <option value="">All</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('filter') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <label for="search" class="visually-hidden"></label>
            <input type="text" name="search" class="form-control" id="search" placeholder="Search"
                value="{{ request('search') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-5">Cari</button>
        </div>
    </form>
@endsection

@section('content')
    @foreach ($products as $item)
        <div class="col mb-5">
            <div class="card h-100">
                <!-- Product image-->
                <img class="card-img-top" src="/storage/{{ $item->image }}" width="150" alt="..." />
                <!-- Product details-->
                <div class="card-body p-4">
                    <div class="text-center">
                        <!-- Product name-->
                        <h5 class="fw-bolder">{{ $item->name }}</h5>
                        <!-- Product price-->
                        Rp.{{ number_format($item->price, 2) }} <br>
                        Stock : {{ $item->stock }}
                    </div>
                </div>
                <!-- Product actions-->
                <div class="row card-footer p-4 pt-0 border-top-0 bg-transparent justify-content-center align-items-center">
                    <div class="col-10 col-md-8 col-lg-6">
                        <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $item->id }}" name="id">
                            <input type="hidden" value="{{ $item->name }}" name="name">
                            <input type="hidden" value="{{ $item->price }}" name="price">
                            <input type="hidden" value="{{ $item->image }}" name="image">
                            <input type="hidden" value="1" name="quantity">
                            <button class="btn btn-outline-dark mt-auto text-center">Add To Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
