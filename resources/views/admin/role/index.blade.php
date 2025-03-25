@extends('auth.layouts.app')

@section('title', 'All Roles')

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
              <h6 class="text-white text-capitalize ps-3">All Role
                @can('has-permission', ['create', 'role'])
                <a href="{{ url('/admin/roles/create') }}" class="btn btn-primary ms-4">Create</a></h6>
                @endcan
            </div>
          </div>
          <div class="card-body px-0 pb-2">
            @error('message')
            <div class="alert alert-danger text-white mt-4 mx-3">{{ $message }}</div>
            @enderror
            @if(Session::has('success'))
            <div class="alert alert-success text-white mt-4 mx-3">{{ Session::get('success') }}</div>
            @endif
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role name</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
                </thead>
                <tbody>
                  @if (count($roles) > 0)
                    @foreach ($roles as $role)  
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{ ucfirst($role->name) }}</h6>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle">
                        @can('has-permission', ['update', 'role'])
                        <a href="{{ url('/admin/roles/' . $role->id) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit role">
                          Edit
                        </a>
                        @endcan
                        @can('has-permission', ['delete', 'role'])
                        <span> | </span>
                        <a href="#" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete role" onclick="event.preventDefault(); document.getElementById('deleteRole{{ $role->id }}').submit();">
                          Delete
                        </a>
                        <form action="{{ url('/admin/roles/' . $role->id) }}" method="POST" id="deleteRole{{ $role->id }}">
                          @csrf
                          @method('delete')
                        </form>
                        @endcan
                      </td>
                    </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection