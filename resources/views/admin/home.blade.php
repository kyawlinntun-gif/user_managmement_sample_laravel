@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
@include('admin.layouts.components.asidebar')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  @include('admin.layouts.components.navbar')
  <div class="container-fluid py-2">
    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          @if(Session::has('success'))
          <div class="alert alert-success text-white mt-4 mx-3">{{ Session::get('success') }}</div>
          @endif
          <div class="card-header text-center"><h3>Manage Setting</h3></div>
          <div class="card-body">
            @if ($errors->any())
              <div class="alert alert-danger">
                  <ol>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                  </ol>
              </div>
            @endif
            <form action="{{ url('/admin/all-update') }}" method="POST">
              @csrf
              @foreach ($admin_users as $admin_user)
                @if (!is_null($admin_user->role_id))
                  <h5>
                    {{ $admin_user->username }}
                    (Role:
                    <select name="roles[{{ $admin_user->id }}]"
                      {{ Gate::denies('has-role', 'admin') ? 'disabled' : ''; }}
                      >
                      @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ $role->id === $admin_user->role_id ? 'selected' : ''; }}>{{ $role->name }}</option>
                      @endforeach
                    </select>
                    )
                  </h5>
                  <table border="1" cellpadding="5" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Feature</th>
                        <th>Permissions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($features as $feature)
                        <tr>
                          <td>
                            @php
                              $featureIds = $admin_user?->role?->permissions?->pluck('feature_id')->unique()->toArray();
                            @endphp
                            <label>
                              <input type="checkbox" name="features[{{ $admin_user->id }}][]" value="{{ $feature->id }}" class="feature-checkbox" data-user="{{ $admin_user->id }}"
                              {{ in_array($feature->id, $featureIds) ? 'checked' : ''; }}
                              {{ Gate::denies('has-role', 'admin') ? 'disabled' : ''; }}
                              >
                              {{ $feature->name }}
                            </label>
                          </td>
                          <td>
                            @php
                              $permissionIds = $admin_user?->role?->permissions->pluck('id')->toArray();
                            @endphp
                            @foreach ($permissions as $permission)
                              @if ($permission->feature_id === $feature->id)
                                <label>
                                  <input type="checkbox" name="permissions[{{ $admin_user->id }}][]" data-feature="{{ $feature->id }}" data-user="{{ $admin_user->id }}" class="permission-checkbox" value="{{ $permission->id }}"
                                  {{ in_array($permission->id, $permissionIds) ? 'checked' : ''; }}
                                  {{ Gate::denies('has-role', 'admin') ? 'disabled' : ''; }}
                                  >
                                  {{ $permission->name }}
                                </label>
                              @endif
                            @endforeach
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                @endif
              @endforeach
              <hr>
              @can('has-role', 'admin')
              <button type="submit">Save Changes</button>
              @endcan
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".feature-checkbox").forEach(featureCheckbox => {
      featureCheckbox.addEventListener("change", function() {
        let userId = this.dataset.user;
        document.querySelectorAll(`.permission-checkbox[data-user='${userId}'][data-feature='${this.value}']`).forEach(permissionCheckbox => {
          permissionCheckbox.checked = this.checked;
        });
      });
    });
  });
</script>
@endsection