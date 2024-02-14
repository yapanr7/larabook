<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Models\Package;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::latest()->paginate(10); // Adjust the number as per your requirement
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric|min:'.$request->input('minimal_booking_price', 0),

                'description' => 'required|string',
                'minimal_booking_price' => 'nullable|numeric',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            // Use a transaction to ensure data consistency in case of an exception
            DB::beginTransaction();

            $imagePath = $request->file('image')->store('package_images', 'public');

            Package::create([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'minimal_booking_price' => $request->minimal_booking_price,
                'image' => $imagePath,
                'slug' => Str::slug($request->name),
            ]);

            // Commit the transaction if everything is successful
            DB::commit();

            return redirect()->route('admin.packages.index')->with('success', 'Package created successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            // Get the exception message
            $errorMessage = $e->getMessage();

            // Display the exception message in the error feedback
            return redirect()->route('admin.packages.create')->with('error', "Failed to create the package. Error: $errorMessage");
        }
    }


    public function edit($id)
    {
        $decrypted = decrypt($id);
        $package = Package::findOrFail($decrypted);
        $packageId = $id;

        return view('admin.packages.edit', compact('package', 'packageId'));
    }


    public function update(Request $request, $id)
    {
        $packageId = decrypt($id);
        $package = Package::findOrFail($packageId);

        try {
            $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric|min:'.$request->input('minimal_booking_price', 0),
                'description' => 'required|string',
                'minimal_booking_price' => 'nullable|numeric',

                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            // Use a transaction to ensure data consistency in case of an exception
            DB::beginTransaction();

            // Update the package fields
            $package->name = $request->name;
            $package->price = $request->price;
            $package->description = $request->description;
            $package->minimal_booking_price = $request->minimal_booking_price;

            // Update the image if provided
            if ($request->hasFile('image')) {
                // Delete the existing image
                Storage::disk('public')->delete($package->image);

                // Store the new image
                $imagePath = $request->file('image')->store('package_images', 'public');
                $package->image = $imagePath;
            }

            // Save the changes to the package
            $package->save();

            // Commit the transaction if everything is successful
            DB::commit();

            return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            // Get the exception message
            $errorMessage = $e->getMessage();

            // Display the exception message in the error feedback
            return redirect()->route('admin.packages.edit', $package)->with('error', "Failed to update the package. Error: $errorMessage");
        }
    }


    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully.');
    }

    public function show($slug)
    {
        $package = Package::where('slug', $slug)->firstOrFail();
        $galleries = Gallery::where('package_id', $package->id)->get();

        return view('admin.packages.show', compact('package', 'galleries'));
    }


    public function addGallery(Request $request, Package $package)
    {
        try {
            $request->validate([
                'images' => 'required|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            // Use a transaction to ensure data consistency in case of an exception
            DB::beginTransaction();

            foreach ($request->file('images') as $image) {
                $uniqueName = 'gallery_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('package_galleries', $uniqueName, 'public');

                Gallery::create([
                    'image' => $imagePath,
                    'package_id' => $package->id,
                ]);
            }

            // Commit the transaction if everything is successful
            DB::commit();

            return redirect()->route('admin.packages.show', $package->slug)->with('success', 'Gallery added successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an exception
            DB::rollBack();
            // Get the exception message
            $errorMessage = $e->getMessage();

            // Display the exception message in the error feedback
            return redirect()->route('admin.packages.show', $package->slug)->with('error', "Failed to add gallery. Error: $errorMessage");
        }
    }

    public function deleteGallery(Gallery $gallery)
    {
        // Hapus gambar dari penyimpanan
        Storage::disk('public')->delete($gallery->image);
        // Hapus galeri dari database
        $gallery->delete();
        return back()->with('success', 'Gallery deleted successfully.');
    }

}
