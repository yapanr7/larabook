@extends('layouts.admin')

@section('content')

    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="row g-4">
                        <div class="col-sm-auto">
                            <div>
                                <a href="{{ route('admin.packages.create') }}" class="btn fw-bold btn-primary">New Package</a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- end card header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table ">
                            <thead class="thead">
                                <tr class="tr">
                                    <th>Package</th>
                                    <th>Price</th>
                                    <th>Minimal Booking Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody >
                                @foreach ($packages as $package)
                                    <tr >

                                        <td ><span>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar-sm bg-light rounded p-1"><img
                                                                src="{{ asset('storage/' . $package->image) }}"
                                                                alt="" class="img-fluid d-block">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="fs-14 mb-1"><a href="apps-ecommerce-product-details.html"
                                                                class="text-body">{{ $package->name }}</a>
                                                        </h5>

                                                    </div>
                                                </div>
                                            </span></td>
                                        <td class="fw-bold"><i>Rp.</i>{{ number_format($package->price) }}</td>
                                        <td class="fw-bold">
                                            <i>Rp.</i>{{ number_format($package->minimal_booking_price) }}</span>
                                        </td>

                                        <td ><span>
                                                <div class="dropdown"><button class="btn btn-soft-secondary btn-sm dropdown"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false"><i
                                                            class="ri-more-fill"></i></button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('admin.packages.show', $package->slug) }}"><i
                                                                    class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                                View</a></li>
                                                        <li><a class="dropdown-item edit-list" data-edit-id="1"
                                                                href="{{ route('admin.packages.edit', encrypt($package->id)) }}"><i
                                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                Edit</a></li>
                                                        <li class="dropdown-divider"></li>
                                                        <li>
                                                            <form
                                                                action="{{ route('admin.packages.destroy', encrypt($package->id)) }}"
                                                                method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item remove-list"
                                                                    onclick="return confirm('Are you sure you want to delete this package?')"><i
                                                                        class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                    Delete</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                        {{ $packages->links() }}
                </div>
                <!-- end card body -->
            </div>
        </div>
    </div>
@endsection
