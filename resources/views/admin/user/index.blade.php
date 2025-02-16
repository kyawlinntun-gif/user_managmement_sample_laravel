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
                  @if(isset($admin_users))
                    @if(count($admin_users) > 0)
                      @foreach($admin_users as $admin_user)
                        <tr>
                          <td>
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">{{ $admin_user->name }}</h6>
                            </div>
                          </td>
                          <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $admin_user->username }}</p>
                          </td>
                          <td>
                            <p class="text-xs font-weight-bold mb-0">{{ isset($admin_user->role->name) ? $admin_user->role->name : ''; }}</p>
                          </td>
                          <td class="align-middle text-center text-sm">
                            <span class="badge badge-sm bg-gradient-success">{{ $admin_user->phone }}</span>
                          </td>
                          <td class="align-middle text-center text-sm">
                            <span class="badge badge-sm bg-gradient-success">{{ $admin_user->email }}</span>
                          </td>
                          <td class="align-middle text-center text-sm">
                            <span class="badge badge-sm bg-gradient-success">{{ $admin_user->address }}</span>
                          </td>
                          <td class="align-middle text-center text-sm">
                            <span class="badge badge-sm bg-gradient-success">{{ $admin_user->gender == 1 ? 'Male' : 'Female'; }}</span>
                          </td>
                          <td class="align-middle text-center text-sm">
                            <span class="badge badge-sm bg-gradient-success">{{ $admin_user->is_active = 1 ? 'Active' : 'Inactive'; }}</span>
                          </td>
                          <td class="align-middle">
                            <a href="{{ url('/admin/users/' . $admin_user->id) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                              Edit
                            </a>
                            @if(auth()->user()->id !== $admin_user->id && optional($admin_user->role)->name !== 'admin') 
                            @can('has-permission', ['delete', 'user'])
                            <span> | </span>
                            <a href="#" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete user" onclick="event.preventDefault(); document.getElementById('deleteAdminUser{{ $admin_user->id }}').submit();">
                              Delete
                            </a>
                            <form action="/admin/users/{{ $admin_user->id }}/delete" method="POST" id="deleteAdminUser{{ $admin_user->id }}" class="d-none">
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