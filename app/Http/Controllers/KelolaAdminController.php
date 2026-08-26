<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KelolaAdminController extends Controller
{
    /**
     * Menampilkan halaman Kelola Admin
     */
    public function index()
    {
        $users = User::where('role', 'admin')
            ->latest()
            ->get();

        return view('admin.index', compact('users'));
    }


    /**
     * Menyimpan Admin baru
     */
    public function tambahAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                'in:admin',
            ],
        ], [
            'name.required' => 'Nama wajib diisi.',

            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',

            'role.required' => 'Role wajib dipilih.',
        ]);


        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);


        return redirect()
            ->route('admin.kelolaadmin')
            ->with('success', 'Admin berhasil ditambahkan.');
    }


    /**
     * Menampilkan halaman Edit Admin
     */
    public function edit($id)
    {
        $admin = User::where('role', 'admin')
            ->findOrFail($id);

        return view('admin.edit-admin', compact('admin'));
    }


    /**
     * Memperbarui Admin
     */
    public function update(Request $request, $id)
    {
        $admin = User::where('role', 'admin')
            ->findOrFail($id);


        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username,' . $id,
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $id,
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'name.required' => 'Nama wajib diisi.',

            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',

            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);


        $data = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
        ];


        // Kalau password diisi,
        // password lama diganti.
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make(
                $validated['password']
            );
        }


        $admin->update($data);


        return redirect()
            ->route('admin.kelolaadmin')
            ->with('success', 'Data Admin berhasil diperbarui.');
    }


    /**
     * Menghapus Admin
     */
    public function delete($id)
    {
        $admin = User::where('role', 'admin')
            ->findOrFail($id);


        $admin->delete();


        return redirect()
            ->route('admin.kelolaadmin')
            ->with('success', 'Admin berhasil dihapus.');
    }
}