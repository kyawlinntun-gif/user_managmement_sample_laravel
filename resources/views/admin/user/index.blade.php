@extends('admin.layouts.app')

@section('title', 'Admin Users')

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
              <h6 class="text-white text-capitalize ps-3">All Admin Users
                @can('has-permission', ['create', 'user'])
                <a href="{{ url('/admin/users/create') }}" class="btn btn-primary ms-4">Create</a>
                @endcan
              </h6>
            </div>
          </div>
          <div class="card-body px-0 pb-2">
            @if(Session::has('success'))            
            <div class="alert alert-success text-white mt-4 mx-3">{{ Session::get('success') }}</div>
            @endif
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Username</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phone</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Address</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Gender</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">is_active</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
                </thead>
                <tbody>
                  @if(isset($adminUsers))
                    @if(count($adminUsers) > 0)
                      @foreach($adminUsers as $adminUser)
                        <tr>
                          <td>
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">{{ $adminUser->name }}</h6>
                            </div>
                          </td>
                          <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $adminUser->username }}</p>
                          </td>
                          <td>
                            <p class="text-xs font-weight-bold mb-0">{{ isset($adminUser->role->name) ? $adminUser->role->name : ''; }}</p>
                          </td>
                          <td class="align-middle text-center text-sm">
                            <span class="badge badge-sm bg-gradient-success">{{ $adminUser->phone }}</span>
                          </td>
                          <td class="align-middle text-center text-sm">
                            <span class="badge badge-sm bg-gradient-success">{{ $adminUser->email }}</span>
                          </td>
                          <td class="align-middle text-center text-sm">
                            <span class="badge badge-sm bg-gradient-success">{{ $adminUser->address }}</span>
                          </td>
                          <td class="align-middle text-center text-sm">
                            <span class="badge badge-sm bg-gradient-success">{{ $adminUser->gender == 1 ? 'Male' : 'Female'; }}</span>
                          </td>
                          <td class="align-middle text-center text-sm">
                            <span class="badge badge-sm {{ $adminUser->is_active == 1 ? 'bg-gradient-success': 'bg-gradient-warning' }}">{{ $adminUser->is_active == 1 ? 'Active' : 'Inactive'; }}</span>
                          </td>
                          <td class="align-middle">
                            @can('has-permission', ['update', 'user'])
                            <a href="{{ url('/admin/users/' . $adminUser->id) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                              Edit
                            </a>
                            @endcan
                            @if(auth()->user()->id !== $adminUser->id && optional($adminUser->role)->name !== 'admin') 
                            @can('has-permission', ['delete', 'user'])
                            <span> | </span>
                            <a href="#" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete user" onclick="event.preventDefault(); document.getElementById('deleteAdminUser{{ $adminUser->id }}').submit();">
                              Delete
                            </a>
                            <form action="{{ url('/admin/users/' . $adminUser->id) }}" method="POST" id="deleteAdminUser{{ $adminUser->id }}" class="d-none">
                              @csrf
                              @method('delete')
                            </form>
                            @endcan
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    @endif
                  @endif;
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