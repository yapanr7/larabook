<div class="btn-group" role="group" aria-label="Booking Actions">
    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-info" title="View Booking">
        <i class="ri-eye-fill"></i>
    </a>

    <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-sm btn-warning" title="Edit Booking">
        <i class="ri-edit-line"></i>
    </a>

    <button type="button" class="btn btn-sm btn-danger" title="Delete Booking" onclick="confirmDeletion({{ $booking->id }})">
        <i class="ri-delete-bin-fill"></i>
    </button>
</div>

<script>

function confirmDeletion(bookingId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Jika dikonfirmasi, kirimkan permintaan DELETE ke route yang sesuai
            axios.delete(`/admin/bookings/${bookingId}`)
                .then(response => {
                    // Handle respons jika perlu
                    // Misalnya, refresh halaman atau perbarui tampilan
                    location.reload();
                })
                .catch(error => {
                    // Handle kesalahan jika perlu
                    console.error(error);
                });
        }
    });
}
</script>
