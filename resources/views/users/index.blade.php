@extends('back.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Data User</h4>


    @can('create-user')
          <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New User</a>
          @endcan


    <!-- Bootstrap Table with Caption -->
    <div class="card">
      <h5 class="card-header">Data rules</h5>

      <div class="table-responsive text-nowrap">

        <table class="table">
          <caption class="ms-4">
            List of roles
          </caption>
          <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Roles</th>
                <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $user)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @forelse ($user->getRoleNames() as $role)
                        <span class="badge bg-primary">{{ $role }}</span>
                    @empty
                    @endforelse
                </td>
                <td>
                    <form action="{{ route('users.destroy', $user->id) }}" method="post">
                        @csrf
                        @method('DELETE')
        
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>
        
                        @if (in_array('Super Admin', $user->getRoleNames()->toArray() ?? []) )
                            @if (Auth::user()->hasRole('Super Admin'))
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                            @endif
                        @else
                            @can('edit-user')
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>   
                            @endcan
        
                            @can('delete-user')
                                @if (Auth::user()->id!=$user->id)
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this user?');"><i class="bi bi-trash"></i> Delete</button>
                                @endif
                            @endcan
                        @endif
        
                    </form>
                </td>
            </tr>
            @empty
                <td colspan="5">
                    <span class="text-danger">
                        <strong>No User Found!</strong>
                    </span>
                </td>
            @endforelse


          </tbody>
        </table>
      </div>
    </div>
    <!-- Bootstrap Table with Caption -->
    <hr class="my-5" />
    <!--/ Responsive Table -->
  </div>
    
@endsection