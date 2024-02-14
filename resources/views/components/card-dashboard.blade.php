<!-- File: resources/views/components/card-dashboard.blade.php -->

<div class="card card-animate">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div>
                <p class="fw-medium text-muted mb-0">{{ $name }}</p>
                <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $total }}">{{ $total }}</span></h2>
            </div>
            <div>
                <div class="avatar-sm flex-shrink-0">
                    <span class="avatar-title bg-info rounded-circle fs-4">
                        <i class="{{ $icon }}"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
