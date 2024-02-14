<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class BankController extends Controller
{
    public function index(Request $request) : View
    {

        $banks = Bank::latest()->paginate(10);
        return view('admin.banks.index', compact('banks'));
    }

    public function create(): View
    {
        return view('admin.banks.create');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image'     => 'required|image|mimes:webp,jpeg,jpg,png|max:2048',
                'name'     => 'required',
                'holder'     => 'required',
                'account'   => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->route('admin.banks.create')
                    ->withErrors($validator)
                    ->withInput();
            }

            $image = $request->file('image');
            $image->storeAs('public/banks', $image->hashName());

            $bank = new Bank();
            $bank->image = $image->hashName();
            $bank->name = $request->name;
            $bank->holder = $request->holder;
            $bank->account = $request->account;
            $bank->save();

            return redirect()->route('admin.banks.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } catch (\Exception $e) {
            // Handle exception, bisa ditambahkan logging atau pesan khusus sesuai kebutuhan
            return redirect()->route('admin.banks.create')->with(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(string $id)
    {
        return redirect()->back();
    }


    public function edit(string $id): View
    {

        $bank = Bank::findOrFail($id);
        return view('admin.banks.edit', compact('bank'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'image'     => 'image|mimes:webp,jpeg,jpg,png|max:2048',
            'name'     => 'required',
            'account'   => 'required'
        ]);

        $bank = Bank::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $image->storeAs('public/banks', $image->hashName());
            Storage::delete('public/banks/'.$bank->image);

            $bank->update([
                'image'     => $image->hashName(),
                'name'     => $request->name,
                'holder'     => $request->holder,
                'account'   => $request->account
            ]);

        } else {

            $bank->update([
                'name'     => $request->name,
                'holder'     => $request->holder,
                'account'   => $request->account
            ]);
        }

        //redirect to index
        return redirect()->route('admin.banks.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id): RedirectResponse
    {
        $bank = Bank::findOrFail($id);
        Storage::delete('public/banks/'. $bank->image);
        $bank->delete();
        return redirect()->route('admin.banks.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
