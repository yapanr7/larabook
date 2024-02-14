@extends('layouts.app')

@section('content')

    <div class="container mt-80">
        <div class="foreground ">
            <div class="top-wid-bg">
                <img src="{{ asset('storage/' . $package->image) }}" alt="" class="top-wid-img">
            </div>
        </div>
        <div class="pt-4 mb-4 mb-lg-3 home-wrapper">
            <div class="row g-4">

                <!--end col-->
                <div class="col">
                    <div class="p-2">
                        <h1 class="text-white mb-1">{{ $package->name }}</h1>
                        <h4 class="text-white text-opacity-75">{{ $package->description }}</h4>

                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>

    <div class="mt-5 container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row gx-lg-5">
                    <div class="col-xl-4 mb-3 mx-auto">
                        <div class="card card-animate">
                            <div class="card-body p-2 rounded bg-white">
                                <img src="{{ asset('storage/' . $package->image) }}" alt="Package Image"
                                    class="img-fluid rounded d-block" />
                            </div>
                        </div>

                        <div class="card card-animate">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Info</h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <th class="ps-0" scope="row">
                                                    Price
                                                </th>
                                                <td class="text-muted">{{ formatRupiah($package->price) }}</td>
                                            </tr>
                                            <tr>
                                                <th class="ps-0" scope="row">Booking Price :</th>
                                                <td class="text-muted">{{ formatRupiah($package->minimal_booking_price) }}
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-8">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="mt-xl-0 mt-5">

                                    <!-- Daftar bulan -->
                                    <div class="row mb-3" id="monthListContainer">
                                        @foreach ($months as $month)
                                            <div class="col-4">
                                                <button type="button"
                                                    class="btn btn-sm w-100 mb-2 btn-primary fw-bold btn-block monthPickerItem"
                                                    data-month="{{ $month }}">
                                                    {{ Carbon\Carbon::parse($month)->format('F Y') }}
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-12 col-lg-8 mx-auto">
                                            <div class="swiper-container" style="overflow: hidden">
                                                <div class="swiper-wrapper" id="dateListContainer">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row" id="timeSlotsContainer"></div>
                                    <div class="mt-4">
                                        @auth

                                            @if (auth()->user()->email_verified_at)
                                                <button class="btn btn-primary bg-custom text-white w-100 fw-bold"
                                                    id="openBookingModal">Booking Now!</button>
                                                    @else

                                        <a href="{{ route('verification.notice')}}" class="btn btn-primary bg-custom text-white w-100 fw-bold"
                                        >Verifikasi akun untuk booking</a>
                                            @endif
                                        @endauth
                                        @guest

                                            <a href="{{ route('login') }}"
                                                class="btn btn-primary bg-custom text-white w-100 fw-bold"
                                                id="loginBooking">Login to Booking!</a>
                                        @endguest
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>


        @if ($package->galleries->isEmpty())
        @else
            <hr>
            <div class="row gallery-wrapper">
                @foreach ($package->galleries as $gallery)
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="card rouded shadow-lg card-animate">
                            <img src="{{ asset('storage/' . $gallery->image) }}" style="object-fit: cover;"
                                class="card-img-top" height="250" alt="{{ $package->name }}">
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Booking Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah yakin anda akan membooking?</p>


                    <div class="table-responsive">
                        <table class="table">
                            <thead>

                                <tr>
                                    <th>Package</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>

                                    <td><span id="packageName">{{ $package->name }}</span></td>
                                    <td><span id="bookingDate"></span></td>
                                    <td><span id="bookingTime"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="confirmBookingButton">Confirm Booking</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const timeSlotsContainer = document.getElementById('timeSlotsContainer');
                const monthListContainer = document.getElementById('monthListContainer');
                const dateListContainer = document.getElementById('dateListContainer');

                // Mendapatkan tanggal saat ini dalam format "YYYY-MM-DD"
                const currentDate = new Date();
                const currentYear = currentDate.getFullYear();
                const currentMonth = (currentDate.getMonth() + 1).toString().padStart(2, '0');
                const currentDay = currentDate.getDate().toString().padStart(2, '0');
                const currentDateFormatted = `${currentYear}-${currentMonth}-${currentDay}`;

                const openBookingButton = document.getElementById('openBookingModal');
                openBookingButton.addEventListener('click', openBookingModal);

                // Event listener untuk tombol booking

                console.log(currentDateFormatted);
                // Mendapatkan bulan saat ini dalam format "YYYY-MM"
                const currentMonthFormatted = `${currentYear}-${currentMonth}`;


                // Inisialisasi selectedMonthButton dengan bulan saat ini
                let selectedMonthButton = document.querySelector(`[data-month="${currentMonthFormatted}"]`);
                let selectedDateButton = null;
                // Periksa apakah selectedMonthButton ditemukan
                if (selectedMonthButton) {
                    selectedMonthButton.classList.add('btn-success');
                    // Setelah memilih bulan, panggil fungsi fetchDatesByMonth untuk merender tanggal
                    fetchDatesByMonth(selectedMonthButton.getAttribute('data-month'));
                }


                let selectedTimeButton = null; // Variable to store the currently selected time button


                function fetchAvailableSlots(date) {
                    axios.get('{{ route('bookings.getAvailableSlots') }}', {
                            params: {
                                date: date
                            }
                        })
                        .then(response => {
                            // Update the time slots container with the response
                            renderTimeSlots(response.data);
                        })
                        .catch(error => {
                            console.error('Error fetching available time slots:', error);
                        });
                }

                function fetchDatesByMonth(month) {

                    axios.get('{{ route('bookings.getDates') }}', {
                            params: {
                                month: month
                            }
                        })
                        .then(response => {

                            // Update date container with the response
                            renderDates(response.data);

                            // Remove success class from the previously selected month button
                            if (selectedMonthButton) {
                                selectedMonthButton.classList.remove('btn-success');
                            }

                            // Set the currently selected month button
                            selectedMonthButton = document.querySelector(`[data-month="${month}"]`);

                            // Add success class to the selected month button
                            if (selectedMonthButton) {
                                selectedMonthButton.classList.add('btn-success');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching available dates:', error);
                        });

                }

                function renderDates(dates) {
                    dateListContainer.innerHTML = dates.map(date => `
                    <div class="swiper-slide">
                        <button type="button" style="height:60px" class="btn fw-bold w-100 shadow btn-sm btn-primary datePickerItem"
                            data-date="${date.date}">
                            ${date.tanggal}
                            <br>
                           <small> ${date.hari}</small>
                        </button>
                    </div>
                `).join('');

                    // Inisialisasi selectedDateButton dengan tanggal saat ini
                    let selectedDateButton = document.querySelector(`[data-date="${currentDateFormatted}"]`);

                    // Periksa apakah selectedDateButton ditemukan
                    if (selectedDateButton) {
                        selectedDateButton.classList.add('btn-primary');
                        // Setelah memilih tanggal, panggil fungsi fetchAvailableSlots untuk merender slot waktu
                        fetchAvailableSlots(selectedDateButton.getAttribute('data-date'));
                    }

                    // Initialize Swiper after rendering dates
                    const swiper = new Swiper('.swiper-container', {
                        slidesPerView: '6',
                        spaceBetween: 16,

                        navigation: {
                            nextEl: '.swiper-button-next-unique',
                            prevEl: '.swiper-button-prev-unique',
                        },

                    });

                    // Add event listeners after rendering the buttons
                    addDateListeners();
                }

                function addDateListeners() {
                    const datePickerItems = document.querySelectorAll('.datePickerItem');
                    datePickerItems.forEach(item => {
                        item.addEventListener('click', function() {
                            // Remove success class from the previously selected date button
                            if (selectedDateButton) {
                                selectedDateButton.classList.remove('btn-success');
                            }

                            // Set the currently selected date button
                            selectedDateButton = this;

                            // Add success class to the selected date button
                            selectedDateButton.classList.add('btn-success');

                            const selectedDate = this.getAttribute('data-date');
                            fetchAvailableSlots(selectedDate);
                        });
                    });
                }

                // Event listener for month selection
                monthListContainer.addEventListener('click', function(event) {
                    if (event.target.classList.contains('monthPickerItem')) {
                        const selectedMonth = event.target.getAttribute('data-month');
                        fetchDatesByMonth(selectedMonth);
                    }
                });

                // Function to render available time slots
                function renderTimeSlots(slots) {
                    timeSlotsContainer.innerHTML = slots.map(slot => `
                    <div class="col-3 col-md-3 col-lg-2 mb-3">
                        <button data-time="${slot.time}" class="btn w-100 shadow btn-sm fw-bold ${slot.isAvailable ? 'btn-primary' : 'btn-dark'} timePickerItem">
                            ${slot.time}
                        </button>
                    </div>
                `).join('');

                    // Add event listeners after rendering the time slots
                    addTimeListeners();
                }

                function addTimeListeners() {
                    const timePickerItems = document.querySelectorAll('.timePickerItem');
                    timePickerItems.forEach(item => {
                        item.addEventListener('click', function() {
                            // Remove success class from the previously selected time button
                            if (selectedTimeButton) {

                                selectedTimeButton.classList.remove('btn-success');
                            }

                            // Set the currently selected time button
                            selectedTimeButton = this;


                            // Add success class to the selected time button
                            selectedTimeButton.classList.add('btn-success');
                        });
                    });
                }


                function openBookingModal() {
                    // Tampilkan modal saat tombol "Booking Now!" diklik
                    const bookingModal = new bootstrap.Modal(document.getElementById('bookingModal'));
                    bookingModal.show();

                    // Set nilai tanggal pada elemen dengan id 'bookingDate'
                    if (selectedDateButton) {
                        // Jika Anda ingin mengirimkan format tanggal dan tahun ke formulir, Anda dapat mengonversi formatnya
                        const selectedDate = selectedDateButton.getAttribute('data-date');
                        document.getElementById('bookingDate').textContent = selectedDate;
                    }

                    if (selectedTimeButton) {
                        // Jika Anda ingin mengirimkan format tanggal dan tahun ke formulir, Anda dapat mengonversi formatnya
                        const selectedTime = selectedTimeButton.getAttribute('data-time');
                        document.getElementById('bookingTime').textContent = selectedTime;
                        console.log(selectedTime);
                    }

                    // Event listener untuk tombol "Konfirmasi"
                    const confirmBookingButton = document.getElementById('confirmBookingButton');

                    // Hapus listener sebelumnya jika ada
                    confirmBookingButton.removeEventListener('click', confirmBookingButtonClickHandler);

                    // Tambahkan listener yang baru
                    confirmBookingButton.addEventListener('click', confirmBookingButtonClickHandler);
                }

                // Event handler untuk tombol "Konfirmasi"
                function confirmBookingButtonClickHandler() {
                    // Validasi sebelum melakukan booking
                    if (!selectedDateButton || !selectedTimeButton) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Booking Error',
                            text: 'Silahkan pilih waktu dan tanggal terlebih dahulu.',
                        });
                        return;
                    }

                    // Lanjutkan dengan proses booking jika validasi berhasil
                    processBooking();
                }


                async function processBooking() {
                    try {
                        // Mendapatkan tombol konfirmasi
                        const confirmBookingButton = document.getElementById('confirmBookingButton');

                        // Menonaktifkan tombol untuk menunjukkan proses sedang berlangsung
                        confirmBookingButton.disabled = true;

                        // Contoh: Kirim data ke server menggunakan Axios atau jQuery AJAX
                        const selectedDate = selectedDateButton.getAttribute('data-date');
                        const selectedTime = selectedTimeButton.getAttribute('data-time');
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        const response = await axios.post('{{ route('packages.booking') }}', {
                            package_id: '{{ encrypt($package->id) }}',
                            date: selectedDate,
                            time: selectedTime,
                            note: null,
                            _token: csrfToken,
                        });

                        // Aktifkan kembali tombol setelah proses selesai
                        confirmBookingButton.disabled = false;

                        // Tampilkan notifikasi sukses
                        await Swal.fire({
                            icon: 'success',
                            title: 'Booking Successful!',
                            text: 'Your booking has been created successfully.',
                        });

                        // Redirect to the bookings.payment route with the obtained reference
                        window.location.href = '{{ url('booking/') }}/' + response.data.code;
                    } catch (error) {
                        // Aktifkan kembali tombol setelah proses selesai
                        confirmBookingButton.disabled = false;

                        // Tampilkan notifikasi error
                        await Swal.fire({
                            icon: 'error',
                            title: 'Booking Failed',
                            text: 'Failed to create booking. ' + error.message,
                        });
                    }
                }


            });
        </script>
    @endpush

@endsection
