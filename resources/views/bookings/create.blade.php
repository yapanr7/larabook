@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 80px">
        <div class="mt-5">

            <div class="card mt-5">
                <div class="card-body">

                    <h4 class="fw-bold">Create Booking</h4>

                    @if (session('error'))
                        <div class="alert alert-danger mt-3">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf

                        <!-- Form field for selecting package -->
                        <div class="mb-3">
                            <label for="package_id" class="form-label">Select Package</label>
                            <select name="package_id" id="package_id"
                                class="form-select @error('package_id') is-invalid @enderror" required>
                                <option value="">Select Package</option>
                                @foreach ($packages as $package)
                                    <option value="{{ $package->id }}">{{ $package->name }}</option>
                                @endforeach
                            </select>
                            @error('package_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="selectedDate" class="form-label">Select Date</label>
                                <select id="selectedDate" class="form-select">
                                    @foreach ($dateRange as $date)
                                        <option value="{{ $date }}">{{ Carbon\Carbon::parse($date)->format('l, j F Y') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <!-- Container for Time Slots -->
                        <div class="row" id="timeSlotsContainer">
                            {{-- User memilih Hari tanggal dan waktu dengan card seperti booking ticket bioskop --}}
                        </div>

                        <!-- Form field for additional notes -->
                        <div class="mb-3">
                            <label for="note" class="form-label">Additional Notes</label>
                            <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror"
                                rows="3"></textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Button to submit the form -->
                        <button type="submit" class="btn btn-primary">Create Booking</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Add Swiper JS and CSS -->
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

        <!-- Your existing script -->

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const timeSlotsContainer = document.getElementById('timeSlotsContainer');
                const swiperWrapper = document.querySelector('.swiper-wrapper');

                // Function to render available days in Swiper
                function renderDays(days) {
                    return days.map(day => `
                        <div class="swiper-slide">
                            <button class="btn btn-outline-primary btn-sm fw-bold">${day}</button>
                        </div>
                    `).join('');
                }

                // Function to render available time slots
                function renderTimeSlots(slots) {
                    const slotsByDate = {};

                    // Group slots by date
                    slots.forEach(slot => {
                        if (!slotsByDate[slot.date]) {
                            slotsByDate[slot.date] = [];
                        }
                        slotsByDate[slot.date].push(slot);
                    });

                    // Render slots by date
                    return Object.keys(slotsByDate).map(date => {
                        const slotsForDate = slotsByDate[date];
                        return `
                            <div class="mb-4">
                                <h5 class="fw-bold">${date}</h5>
                                <div class="row">
                                    ${slotsForDate.map(slot => `
                                        <div class="col-3 col-md-3 col-lg-2 mb-3">
                                            <button class="btn w-100 shadow btn-sm fw-bold ${slot.isAvailable ? 'btn-primary' : 'btn-dark'}">
                                                ${slot.time}
                                            </button>
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        `;
                    }).join('');
                }

                // Function to update time slots container with data
                function updateTimeSlotsContainer(data) {
                    timeSlotsContainer.innerHTML = renderTimeSlots(data);
                }

                // Ajax request to get available time slots
                function fetchAvailableSlots(day) {
                    axios.get('{{ route('bookings.getAvailableSlots') }}', {
                            params: {
                                day: day
                            }
                        })
                        .then(response => {
                            // Update the time slots container with the response
                            updateTimeSlotsContainer(response.data);
                        })
                        .catch(error => {
                            console.error('Error fetching available time slots:', error);
                        });
                }

                // Initial fetch when the page loads
                fetchAvailableSlots();

                // Event listener for Swiper slide change
                const mySwiper = new Swiper('.swiper-container', {
                    slidesPerView: 3,
                    spaceBetween: 10,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    on: {
                        slideChange: function () {
                            const activeSlide = mySwiper.slides[mySwiper.activeIndex];
                            const selectedDay = activeSlide.textContent.trim();
                            fetchAvailableSlots(selectedDay);
                        },
                    },
                });
            });
        </script>
    @endpush
@endsection
