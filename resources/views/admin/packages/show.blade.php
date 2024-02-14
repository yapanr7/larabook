@extends('layouts.admin')

@section('content')
    <h4 class="fw-bold">{{ $package->name }} Detail</h4>

    <div class="card mt-4">
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Package Name</label>
                <p>{{ $package->name }}</p>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <p>{{ $package->price }}</p>
            </div>

            <!-- Tambahkan informasi lainnya sesuai kebutuhan -->

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <p>{{ $package->description }}</p>
            </div>

            <!-- Tambahkan bagian lain sesuai kebutuhan -->
<div class="row">
    <div class="col-3">

        <div class="mb-3">
            <label for="image" class="form-label">Package Image</label>
            <img src="{{ asset('storage/' . $package->image) }}" style="height:200px" alt="Package Image"
                class="img-fluid rounded d-block" />
        </div>

    </div>
</div>


            <div class="mb-3">
                <form action="{{ route('admin.galleries.store', $package) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="new_galleries" class="form-label">Add New Galleries</label>
                    <input type="file" class="form-control @error('images') is-invalid @enderror" id="images"
                        name="images[]" accept="image/*" multiple required>
                    @error('images')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-primary mt-3">Add Galleries</button>
                </form>
            </div>
<hr>
            <div class="row gallery-wrapper">
                @foreach ($package->galleries as $g)
                    <div class="element-item col-xxl-3 col-xl-3 col-sm-3 project designing development"
                        data-category="designing development">
                        <div class="gallery-box card">
                            <div class="gallery-container">

                                <a class="image-popup" href="{{ asset('storage/' . $g->image) }}" title="">
                                    <img class="gallery-img img-fluid mx-auto" src="{{ asset('storage/' . $g->image) }}"
                                        alt="" />
                                    <div class="gallery-overlay">

                                        <form action="{{ route('admin.galleries.delete', $g->id) }}" class="overlay-caption" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm fs-12 btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this gallery?')">Delete</button>
                                        </form>
                                    </div>
                                </a>
                            </div>

                            <div class="box-content">
                                <div class="d-flex align-items-center mt-1">
                                    <div class="flex-shrink-0">
                                        <div class="d-flex gap-3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>


    </div>
@endsection
