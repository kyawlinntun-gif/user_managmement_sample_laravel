@extends('auth.layouts.app')

@section('title', 'Home')

@section('content')
<div class="container position-sticky z-index-sticky top-0">
  <div class="home">
    <div class="row">
      <div class="col-12">
        @include('auth.layouts.components.navbar')
        <div class="content">
          @if(count($products) > 0)
            @foreach($products as $product)
            <div class="card">
              <img src="{{ asset('assets/upload/' . $product->image) }}" alt="{{ $product->name }}">
              <h3>{{ $product->name }}</h3>
              <p>{{ $product->description }}</p>
            </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection