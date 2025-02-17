@extends('admin.layouts.app')

@section('title', 'Edit Permission')

@section('content')
@include('admin.layouts.components.asidebar')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  @include('admin.layouts.components.navbar')
  <div class="container-fluid py-2">
    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
              <h6 class="text-white text-capitalize ps-3">All Permissions / Edit permission</h6>
            </div>
          </div>
          <div class="card-body px-0 pb-2">
            <div class="row">
              <div class="col-md-6 offset-md-2">
                @error('message')
                <div class="alert alert-danger text-white mt-4 mx-3">{{ $message }}</div>
                @enderror
                <form role="form" method="POST" action="{{ url('/admin/permissions/' . $permission->id) }}">
                  @csrf
                  @method('put')
                  <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" placeholder="Permission Name" value="{{ old('permission_name') ?? $permission->name }}" name="permission_name">
                  </div>
                  @error('permission_name')
                  <span class="alert alert-danger form-control" role="alert">{{ $message }}</span>
                  @enderror
                  <div>    
                    <h5>Features</h5>
                    <div class="form-check">
                    @foreach ($features as $feature)  
                    <label>
                        <input type="radio" name="feature_id" value="{{ $feature->id }}" {{ old('feature_id', $permission->feature_id) == $feature->id ? 'checked' : '' }}> {{ $feature->name }}
                    </label>
                    @endforeach
                    @error('feature_id')
                    <span class="alert alert-danger form-control" role="alert">{{ $message }}</span>
                    @enderror
                  </div>
                  <div>
                    <button type="submit" class="btn btn-lg bg-gradient-dark btn-lg mt-4 mb-0">Update</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection