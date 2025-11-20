<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{

    public function index()
    {
        $patients = User::where('role', 'patient')->with('patient')->latest()->get();
        return view('admin.pasien.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.pasien.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'no_hp' => 'required|string',
            'nim_nik' => 'required|string|unique:patients,nim_nik',
            'tgl_lahir' => 'required|date',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        DB::beginTransaction();
        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'patient',
                'no_hp' => $request->no_hp,
            ]);


            $user->patient()->create([
                'nim_nik' => $request->nim_nik,
                'tgl_lahir' => $request->tgl_lahir,
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);

            DB::commit();
            return redirect()->route('admin.pasien.index')->with('success', 'Akun pasien berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal membuat akun pasien: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $user = User::with('patient')->findOrFail($id);
        return view('admin.pasien.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $patient = $user->patient;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'no_hp' => 'required|string',
            'nim_nik' => ['required', 'string', Rule::unique('patients')->ignore($patient->id)],
            'tgl_lahir' => 'required|date',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'password' => 'nullable|string|min:8', 
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


            $patient->update([
                'nim_nik' => $request->nim_nik,
                'tgl_lahir' => $request->tgl_lahir,
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);

            DB::commit();
            return redirect()->route('admin.pasien.index')->with('success', 'Data pasien berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }


    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete(); // Data 'patient' akan terhapus otomatis via onDelete('cascade')
            return redirect()->route('admin.pasien.index')->with('success', 'Akun pasien berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.pasien.index')->with('error', 'Gagal menghapus pasien. Pastikan tidak ada data janji temu terkait.');
        }
    }
}