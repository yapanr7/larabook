@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <a href="{{ route('admin.banks.create') }}" class="btn btn-md btn-dark fw-bold mb-3">Create New</a>
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Holder</th>
                            <th scope="col">Account</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse ($banks as $bank)
                            <tr>
                                <td class="text-center">
                                    <img src="{{ asset('/storage/banks/'.$bank->image) }}" class="rounded" style="width: 40px">
                                </td>
                                <td>{{ $bank->name }}</td>
                                <td>{{ $bank->holder }}</td>
                                <td>{{ $bank->account }}</td>
                                <td class="text-center">
                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('admin.banks.destroy', $bank->id) }}" method="POST">
                                        <a href="{{ route('admin.banks.edit', $bank->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                          @empty
                              <div class="alert alert-danger">
                                  Data Bank belum Tersedia.
                              </div>
                          @endforelse
                        </tbody>
                      </table>
                      {{ $banks->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
