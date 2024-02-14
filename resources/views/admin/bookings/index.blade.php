@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="tasksList">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Bookings</h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex flex-wrap gap-2">
                                <a class="btn btn-danger fw-bold add-btn" href="{{ route('admin.bookings.index') }}"><i
                                        class="ri-refresh align-bottom me-1"></i> Refresh </a>
                                <button class="btn btn-primary fw-bold" data-bs-toggle="modal"
                                    data-bs-target="#addBooking"><i class="ri-add-fill me-1 align-bottom"></i> Add
                                    Booking</button>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form method="GET" action="{{ route('admin.bookings.index') }}">
                        {{-- @csrf --}}
                        <div class="row g-3">
                            <div class="col-xxl-4 col-sm-4">
                                <div class="search-box">
                                    <input type="text" name="reference" class="form-control search bg-light border-light"
                                        placeholder="Search ref code...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->


                            <div class="col-xxl-3 col-sm-4">
                                <input type="text" class="form-control bg-light border-light" id="demo-datepicker"
                                    data-provider="flatpickr" name="date_range" data-date-format="Y-m-d"
                                    data-range-date="true" placeholder="Select date range">
                            </div>
                            <!--end col-->

                            <div class="col-xxl-3 col-sm-4">
                                <div class="input-light">
                                    <select name="booking_status" class="form-control" data-choices id="booking_status">
                                        <option value="all" selected>Status Booking</option>
                                        <option value="pending">pending</option>
                                        <option value="booked">booked</option>
                                        <option value="cancel">cancel</option>
                                    </select>
                                </div>
                            </div>

                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <button type="submit" class="btn btn-primary w-100"> <i
                                        class="ri-equalizer-fill me-1 align-bottom"></i>
                                    Filters
                                </button>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <!--end card-body-->
                <div class="card-body">
                    <div class="table-responsive table-card mb-4">
                        <table class="table align-middle table-nowrap mb-0" id="tasksTable">
                            <thead class="table-success">
                                <tr>
                                    <th>Ref</th>
                                    <th>Dibuat</th>
                                    <th>Customer</th>
                                    <th>Package</th>
                                    <th>Price</th>
                                    <th>Payment</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th>Download</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">

                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td class="id"><a href="#"
                                                class="fw-medium link-primary text-uppercase fw-bold">{{ $booking->code }}</a>
                                        </td>
                                        <td><span class="badge bg-primary">{{ $booking->created_at }}</span></td>
                                        <td class="customer_name "><a href="#"
                                                class="fw-bold link-primary">{{ $booking->user->name }}</a></td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="flex-grow-1 fw-bold">{{ $booking->package->name }}</div>


                                                <div class="flex-shrink-0 ms-4">
                                                    <ul class="list-inline tasks-list-menu mb-0">

                                                        <li class="list-inline-item"><a class="edit-item-btn"
                                                                href="{{ route('admin.bookings.edit', $booking->id) }}"><i
                                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i></a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                                data-booking-id="{{ $booking->id }}"
                                                                class="remove-item-btn"><i
                                                                    class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                            </a>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold"><i>Rp.</i>{{ number_format($booking->package->price) }}</div></td>

                                            <td>
                                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="fw-bold">
                                                    <i>Rp.</i>{{ number_format($booking->payments->sum('amount')) }}
                                                </a>
                                            </td>

                                        <td><span
                                                class="badge bg-dark">{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}
                                            </span></td>
                                        <td><span class="badge bg-dark">
                                                {{ \Carbon\Carbon::parse($booking->time)->format('H:i') }} </span></td>

                                                                                  <td>
                                            <button
                                                class="btn fw-bold btn-sm {{ $booking->status === 'booked' ? 'btn-success' : ($booking->status === 'pending' ? 'btn-dark' : ($booking->status === 'canceled' ? 'btn-danger' : ($booking->status === 'completed' ? 'btn-info' : 'btn-primary'))) }}"
                                                data-bs-toggle="modal" data-bs-target="#changeStatusModal"
                                                data-booking-id="{{ $booking->id }}">
                                                {{ $booking->status }}
                                            </button>
                                        </td>
                                        <td>

                                            <button
                                            class="btn fw-bold btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#changeDownloadModal"
                                            data-id="{{ $booking->id }}"
                                            data-booking-download="{{ $booking->download }}"
                                            >
                                           <i class="fa fa-download"></i>
                                        </button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class=" mt-2">
                        {{ $bookings->links() }}
                    </div>
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>

    @include('admin.bookings.modals.change_status')
    @include('admin.bookings.modals.change_download')
    @include('admin.bookings.modals.create')
    @include('admin.bookings.modals.delete')
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            // Handle modal show event
            $('#changeStatusModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var bookingId = button.data('booking-id');

                // Set nilai input hidden booking_id pada form modal
                $('#bookingIdInput').val(bookingId);
            });

            $('#changeDownloadModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var bookingId = button.data('id');
                var downloadUrl = button.data('booking-download');
                // Set nilai input hidden booking_id pada form modal
                $('#bookingIdInputDownload').val(bookingId);
                $('#downloadInput').val(downloadUrl);
            });

            $('#deleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var bookingId = button.data('booking-id');
                var modal = $(this);
                modal.find('#deleteForm').attr('action', '/admin/booking/' + bookingId);
            });

        });
    </script>
@endpush
