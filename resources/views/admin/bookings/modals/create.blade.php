<div class="modal fade zoomIn" id="addBooking" tabindex="-1" aria-labelledby="addBookingLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookingLabel">Create Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-content border-0 mt-3">
                <ul class="nav nav-tabs nav-tabs-custom nav-success p-2 pb-0 bg-light" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#createBooking" role="tab" aria-selected="true">
                            Booking Details
                        </a>
                    </li>
                </ul>
            </div>
            <div class="modal-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="createBooking" role="tabpanel">
                        <form action="{{ route('admin.bookings.store')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="firstnameInput" class="form-label">Customer</label>
                                        <select class="form-control" data-choices id="user_id" name="user_id" required>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">
                                                    {{ $user->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="packages" class="form-label">Packages</label>
                                        <select class="form-control" data-choices id="package_id" name="package_id" required>
                                            @foreach ($packages as $package)
                                                <option value="{{ $package->id }}">
                                                    {{ $package->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="date_booking" class="form-label">Tanggal Booking</label>
                                        <input type="date" class="form-control" name="date" id="date_booking">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="waktu" class="form-label">Waktu Booking</label>
                                        <input type="time" class="form-control" name="time" id="waktu" step="1800">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="status_booking" class="form-label">Status Booking</label>
                                    <select class="form-control" data-choices id="status_booking" name="status" required>
                                        <option value="pending">
                                            Pending
                                        </option>
                                        <option value="booked" >
                                            Booked
                                        </option>
                                        <option value="completed">
                                            Completed
                                        </option>
                                        <option value="canceled">
                                            Canceled
                                        </option>
                                    </select>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button class="btn btn-link link-success text-decoration-none fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                                        <button type="submit" class="btn btn-primary"><i class="ri-save-3-line align-bottom me-1"></i> Save</button>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end modal-->
