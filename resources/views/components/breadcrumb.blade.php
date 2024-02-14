<!-- resources/views/components/breadcrumb.blade.php -->

<div class="foreground">
    <div class="top-wid-bg">
        <img src="{{ $image }}" alt="{{ $title }}" class="top-wid-img">
    </div>
</div>

<div class="pt-4 mb-4 mb-lg-3 pb-lg-4 profile-wrapper">
    <div class="row g-4">
        <div class="col">
            <div class="p-2">
                <h2 class="text-white fw-bold mb-1">{{ $title }}</h2>
                <h5 class="text-white text-opacity-75">{{ $description }}</h5>
            </div>
        </div>
    </div>
</div>
