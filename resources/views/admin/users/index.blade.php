@extends('layouts.admin')

@section('page-title', 'Users')

@section('content')
<div class="section-header">
    <div>
        <div class="eyebrow">Accounts</div>
        <h1 class="text-3xl font-bold">Users</h1>
    </div>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Email</th>
                <th>Role</th>
                <th>Joined</th>
                <th class="text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <span class="user-avatar small">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            <strong>{{ $user->name }}</strong>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge {{ $user->isAdmin() ? 'badge-primary' : 'badge-success' }}">{{ $user->role === 'superadmin' ? 'Super Admin' : ucfirst($user->role) }}</span>
                    </td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="flex justify-end gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="role" class="max-w-36">
                                <option value="superadmin" {{ $user->role === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                            </select>
                            <button type="submit" class="action-btn">Save</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-500">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-8">
    {{ $users->links() }}
</div>
@endsection
