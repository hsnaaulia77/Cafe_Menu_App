<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Imports\UsersImport;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:customer,kasir,admin,barista',
            'status' => 'required|in:aktif,nonaktif',
            'catatan' => 'nullable|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:customer,kasir,admin,barista',
            'status' => 'required|in:aktif,nonaktif',
            'catatan' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ];

        // Update password only if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    /**
     * Toggle user status (aktif/nonaktif)
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        // Prevent admin from deactivating themselves
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menonaktifkan akun sendiri!');
        }

        $user->update([
            'status' => $user->status === 'aktif' ? 'nonaktif' : 'aktif'
        ]);

        $status = $user->status === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->name} berhasil {$status}!");
    }

    /**
     * Handle bulk actions on users.
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'action' => 'required|in:activate,deactivate,delete'
        ]);

        $userIds = $request->input('user_ids');
        $action = $request->input('action');
        $currentUserId = auth()->id();

        // Jangan izinkan admin menghapus/menonaktifkan dirinya sendiri
        $userIds = array_diff($userIds, [$currentUserId]);
        if (empty($userIds)) {
            return redirect()->route('admin.users.index')->with('error', 'Tidak ada user yang valid untuk diproses!');
        }

        switch ($action) {
            case 'activate':
                User::whereIn('id', $userIds)->update(['status' => 'aktif']);
                $message = 'User yang dipilih berhasil diaktifkan.';
                break;
            case 'deactivate':
                User::whereIn('id', $userIds)->update(['status' => 'nonaktif']);
                $message = 'User yang dipilih berhasil dinonaktifkan.';
                break;
            case 'delete':
                User::whereIn('id', $userIds)->delete();
                $message = 'User yang dipilih berhasil dihapus.';
                break;
        }

        // Audit log jika ada service
        if (method_exists($this, 'auditService') && isset($this->auditService)) {
            $this->auditService->log('user.bulk_' . $action, [
                'description' => "Bulk action '{$action}' on user IDs: " . implode(', ', $userIds),
                'severity' => $action === 'delete' ? 'warning' : 'info'
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', $message);
    }

    /**
     * Export user data to Excel.
     */
    public function export()
    {
        if (method_exists($this, 'auditService') && isset($this->auditService)) {
            $this->auditService->log('user.export', [
                'description' => 'User exported user data',
                'severity' => 'info'
            ]);
        }
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    /**
     * Import user data from Excel.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);
        Excel::import(new UsersImport, $request->file('file'));
        if (method_exists($this, 'auditService') && isset($this->auditService)) {
            $this->auditService->log('user.import', [
                'description' => 'User imported user data from a file',
                'severity' => 'warning'
            ]);
        }
        return redirect()->route('admin.users.index')->with('success', 'User berhasil diimpor!');
    }

    /**
     * Reset password user oleh admin.
     */
    public function resetPassword(Request $request, User $user): RedirectResponse
    {
        // Tidak boleh reset password sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat reset password akun sendiri!');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        if (method_exists($this, 'auditService') && isset($this->auditService)) {
            $this->auditService->log('user.reset_password', [
                'description' => "Admin reset password user: {$user->email}",
                'severity' => 'warning'
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Password user berhasil direset!');
    }
}
