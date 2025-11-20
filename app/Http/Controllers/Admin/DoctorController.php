<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = User::where('role', 'doctor')->with('doctor')->latest()->get();
        return view('admin.dokter.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.dokter.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'no_hp' => 'required|string',
            'specialties' => 'required|string',
            'nip' => 'nullable|string|unique:doctors,nip',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'doctor', // Langsung set role
                'no_hp' => $request->no_hp,
            ]);

            $user->doctor()->create([
                'specialties' => $request->specialties,
                'nip' => $request->nip,
            ]);

            DB::commit();
            return redirect()->route('admin.dokter.index')->with('success', 'Akun dokter berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal membuat akun dokter: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {

        $user = User::with('doctor')->findOrFail($id);
        return view('admin.dokter.edit', compact('user'));
    }


    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'no_hp' => 'required|string',
            'specialties' => 'required|string',
            'nip' => ['nullable', 'string', Rule::unique('doctors', 'nip')->ignore($user->doctor->id)],
            'password' => 'nullable|string|min:8', // Password opsional
        ]);

        DB::beginTransaction();
        try {

            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
            ];


            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            
            $user->update($userData);

 
            $user->doctor->update([
                'specialties' => $request->specialties,
                'nip' => $request->nip,
            ]);

            DB::commit();
            return redirect()->route('admin.dokter.index')->with('success', 'Data dokter berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }


    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);

            $user->delete();
            return redirect()->route('admin.dokter.index')->with('success', 'Akun dokter berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.dokter.index')->with('error', 'Gagal menghapus dokter.');
        }
    }
}