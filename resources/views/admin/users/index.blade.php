@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">User Management</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search"
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>

            <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Add User</a>
            <div class="table-responsive">

                <table class="table ">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>isVerified</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->is_verified)
                                        <span class="badge bg-success">Verified</span>
                                    @else
                                        <span class="badge bg-warning">Not Verified</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    @if (!$user->is_verified)
            <form action="{{ route('admin.users.verify', $user->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="ri-check-line"></i> Verify
                </button>
            </form>
        @endif
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                        <i class="ri-pencil-line"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure?')">
                                            <i class="ri-delete-bin-line"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $users->appends(['search' => request('search')])->links() }}
        </div>
    </div>
@endsection
