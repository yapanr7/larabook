<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center mb-4">
            <div class="flex-grow-1">
                <h5 class="card-title mb-0">Latest Booking</h5>
            </div>
            <div class="flex-shrink-0">
                <div class="dropdown">
                    <a href="#" role="button" id="dropdownMenuLink1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-more-2-fill fs-14"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end"
                        aria-labelledby="dropdownMenuLink1">
                        <li>
                            <a class="dropdown-item" href="#">View</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Edit</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Delete</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @if($latestBooking->isNotEmpty())
        @foreach($latestBooking as $booking)
        <div class="d-flex mb-4">
            <div class="flex-shrink-0">
                <img src="{{ asset('storage/'. $booking->package->image )}}" alt="{{ $booking->package->name}}"
                    height="50" class="rounded shadow">
            </div>
            <div class="flex-grow-1 ms-3 overflow-hidden">
                <a href="javascript:void(0);">
                    <h6 class="text-truncate fs-14">
                        {{ $booking->package->name}}
                    </h6>
                </a>
                <span class="badge bg-dark mb-0">{{ $booking->status }}</span>
            </div>
        </div>
        @endforeach
        @else

        @endif
    </div>
</div>
