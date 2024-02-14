<div class="modal fade" id="changeDownloadModal" tabindex="-1" aria-labelledby="changeDownloadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeDownloadModalLabel">Download URL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.bookings.change_download') }}" method="POST">
                    @csrf
                    <input type="hidden" name="booking_id" id="bookingIdInputDownload">
                    <div class="mb-3">
                        <label for="newStatus" class="form-label">Download link</label>
                        <input class="form-control" type="text" name="new_download_link" id="downloadInput"/>
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
