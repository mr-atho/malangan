<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('orders')
            ->withSum('orders', 'total');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->loadCount('orders');
        $user->loadSum('orders', 'total');
        $orders = $user->orders()->latest()->take(10)->get();

        return view('admin.users.show', compact('user', 'orders'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:500',
            'password' => 'nullable|string|min:8|confirmed',
        ];

        if ($user->id !== auth()->id()) {
            $rules['role'] = 'required|in:admin,customer';
        }

        $validated = $request->validate($rules);

        $emailChanged = $validated['email'] !== $user->email;

        $user->name    = $validated['name'];
        $user->phone   = $validated['phone'] ?? null;
        $user->address = $validated['address'] ?? null;

        if ($user->id !== auth()->id()) {
            $user->role = $validated['role'];
        }

        if ($emailChanged) {
            $user->email = $validated['email'];
            $user->email_verified_at = null;
        }

        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function toggleRole(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa mengubah role akun sendiri.');
        }

        $user->update(['role' => $user->role === 'admin' ? 'customer' : 'admin']);

        return back()->with('success', 'Role pengguna diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        if ($user->orders()->exists()) {
            return back()->with('error', 'Pengguna memiliki riwayat pesanan dan tidak bisa dihapus.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
