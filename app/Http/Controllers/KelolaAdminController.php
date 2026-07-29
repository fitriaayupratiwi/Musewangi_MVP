<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class KelolaAdminController extends Controller
{
    public function index()
    {

        $users = User::where('role','admin')->get();
        return view('admin.index', compact('users'));
    }

   public function tambahAdmin(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:admin', // Fix di sini
            'password' => 'required|string|min:8',
        ]);


        // Simpan user
       $user = User::create([
        'name' => $validated['name'],
        'username' => $validated['name'],
        'email' => $validated['email'],
        'role' => $validated['role'],
        'password' => bcrypt($validated['password']),
]);

        return redirect()->back()->with('success', 'Admin berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);


        $password = empty($validated['password']) ? $admin->password : bcrypt($validated['password']);

        $data = [
            'name' => $validated["name"] ?? $admin->name,
            'email' => $validated["email"] ?? $admin->email,
            'password' => $password,
        ];
        if ($admin->update($data)) {
            return redirect()->route('admin.kelolaadmin')
                ->with('success', 'Data Admin berhasil diperbarui.');
        }
        ;
        return redirect()->back()->with('success', 'Admin gagal diperbarui.');
    }

    public function delete($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->back()->with('success', 'Admin berhasil dihapus.');
    }

}
