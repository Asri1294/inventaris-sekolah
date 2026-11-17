<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->role, function ($query, $role) {
                $query->where('role', $role);
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());

        ActivityLog::record('create_user', "Menambah akun {$user->name} ({$user->email}) dengan peran {$user->role}.");

        return redirect()->route('users.index')
            ->with('success', 'Akun berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        if ($user->is(auth()->user()) && $data['role'] !== 'admin') {
            return back()->withInput()
                ->with('error', 'Anda tidak dapat menurunkan peran akun Anda sendiri.');
        }

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        ActivityLog::record('update_user', "Mengubah akun {$user->name} ({$user->email}).");

        return redirect()->route('users.index')
            ->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->is(auth()->user())) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun anda sendiri.');
        }

        if ($user->loans()->withTrashed()->exists() || $user->activityLogs()->exists()) {
            return redirect()->route('users.index')
                ->with('error', 'Akun tidak dapat dihapus karena sudah memiliki riwayat peminjaman atau log aktivitas.');
        }

        $user->delete();

        ActivityLog::record('delete_user', "Menghapus akun {$user->name} ({$user->email}).");

        return redirect()->route('users.index')
            ->with('success', 'Akun berhasil dihapus.');
    }
}
