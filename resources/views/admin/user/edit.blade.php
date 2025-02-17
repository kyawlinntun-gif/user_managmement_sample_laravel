@extends('admin.layouts.app')

@section('title', 'Edit Admin User')

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
              <h6 class="text-white text-capitalize ps-3">All Admin Users / Edit admin user</h6>
            </div>
          </div>
          <div class="card-body px-0 pb-2">
            <div class="row">
              <div class="col-md-6 offset-md-2">
              @error('message')
                <div class="alert alert-danger text-white mt-4 mx-3">{{ $message }}</div>
              @enderror
                <form role="form" method="POST" action="{{ url('/admin/users/' . $user->id) }}">
                  @csrf
                  @method('put')
                  <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" placeholder="Name" value="{{ old('name') ?? $user->name }}" name="name">
                  </div>
                  @error('name')  
                    <span class="alert alert-danger form-control" role="alert">{{ $message }}</span>
                  @enderror
                  <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" placeholder="Username" value="{{ old('username') ?? $user->username }}" name="username">
                  </div>
                  @error('username')
                    <span class="alert alert-danger form-control" role="alert">{{ $message }}</span>
                  @enderror
                  <h5>Roles</h5>
                  <div class="form-check">
                  @foreach ($roles as $role)  
                    <label>
                        <input type="radio" name="role_id" value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'checked' : '' }}> {{ $role->name }}
                    </label>
                  @endforeach
                  </div>
                  @error('role_id')
                    <span class="alert alert-danger form-control" role="alert">{{ $message }}</span>
                  @enderror
                  <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" placeholder="Phone" value="{{ old('phone') ?? $user->phone; }}" name="phone">
                  </div>
                  @error('phone')
                    <span class="alert alert-danger form-control" role="alert">{{ $message }}</span>
                  @enderror
                  <div class="input-group input-group-outline mb-3">
                    <input type="email" placeholder="Email" class="form-control" value="{{ old('email') ?? $user->email; }}" name="email">
                  </div>
                  @error('email')
                    <span class="alert alert-danger form-control" role="alert">{{ $message }}</span>
                  @enderror
                  <div class="input-group input-group-outline mb-3">
                    <textarea name="address" id="address" placeholder="Please enter address" class="form-control">{{ old('address') ?? $user->address }}</textarea>
                  </div>
                  @error('address')
                    <span class="alert alert-danger form-control" role="alert">{{ $message }}</span>
                  @enderror
                  <h5>Gender</h2>
                  <div class="form-check">
                    <label>
                        <input type="radio" name="gender" value="1" {{ old('gender', $user->gender) == 1 ? 'checked' : '' }}> Male
                    </label>
                    <label>
                        <input type="radio" name="gender" value="0" {{ old('gender', $user->gender) == 0 ? 'checked' : '' }}> Female
                    </label>
                  </div>
                  @error('gender')
                    <span class="alert alert-danger form-control" role="alert">{{ $message }}</span>
                  @enderror
                  <h5>Active</h5>
                  <div class="form-check">
                    <label>
                        <input type="radio" name="is_active" value="1" {{ old('is_active', $user->is_active) == 1 ? 'checked' : '' }}> Active
                    </label>
                    <label>
                        <input type="radio" name="is_active" value="0" {{ old('is_active', $user->is_active) == 0 ? 'checked' : '' }}> Not Active
                    </label>
                  </div>
                  @error('is_active')
                    <span class="alert alert-danger form-control" role="alert">{{ $message }}</span>
                  @enderror
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