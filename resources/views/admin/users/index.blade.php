@extends('admin.layout')

@section('content')

{{-- HEADER --}}
<div class="section" style="margin-top:0">
    <h3>User Management</h3>
    <p style="color:var(--muted);font-size:14px;">
        Kelola akun, role, status aktif, dan user yang dihapus
    </p>
</div>

{{-- ALERT --}}
@if (session('success'))
<div class="alert success">{{ session('success') }}</div>
@endif

@if (session('error'))
<div class="alert error">{{ session('error') }}</div>
@endif

{{-- TABLE --}}
<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th style="width:220px">Nama</th>
                <th>Email</th>
                <th style="width:120px">Role</th>
                <th style="width:120px">Status</th>
                <th style="width:300px;text-align:center;">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $user)
            <tr>

                {{-- NAMA --}}
                <td>
                    <strong>{{ $user->name }}</strong>
                </td>

                {{-- EMAIL --}}
                <td style="color:var(--muted)">
                    {{ $user->email }}
                </td>

                {{-- ROLE (TEKS + BADGE, TIDAK MUNGKIN HILANG) --}}
                <td>
                    <span class=" {{ $user->role === 'admin' ? 'admin' : 'user' }}">
                        {{ strtoupper($user->role ?? 'USER') }}
                    </span>
                </td>

                {{-- STATUS --}}
                <td>
                    @if ($user->deleted_at)
                    <span class="status deleted">DELETED</span>
                    @elseif ($user->is_active)
                    <span class="status active">ACTIVE</span>
                    @else
                    <span class="status inactive">INACTIVE</span>
                    @endif
                </td>

                {{-- AKSI --}}
                <td style="text-align:center">
                    <div class="actions">

                        @if (!$user->deleted_at)

                        {{-- ENABLE / DISABLE --}}
                        <form method="POST"
                            action="{{ route('admin.users.toggleActive', $user) }}">
                            @csrf
                            @method('PATCH')
                            <button class="btn secondary">
                                {{ $user->is_active ? 'Disable' : 'Enable' }}
                            </button>
                        </form>

                        {{-- ROLE --}}
                        <form method="POST"
                            action="{{ route('admin.users.toggleRole', $user) }}">
                            @csrf
                            @method('PATCH')
                            <button class="btn">
                                {{ $user->role === 'admin'
                                        ? 'Jadikan User'
                                        : 'Jadikan Admin' }}
                            </button>
                        </form>

                        {{-- DELETE --}}
                        <form method="POST"
                            action="{{ route('admin.users.destroy', $user) }}"
                            onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn danger">
                                Delete
                            </button>
                        </form>

                        @else
                        {{-- RESTORE --}}
                        <form method="POST"
                            action="{{ route('admin.users.restore', $user->id) }}">
                            @csrf
                            @method('PATCH')
                            <button class="btn">
                                Restore
                            </button>
                        </form>
                        @endif

                    </div>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- PAGINATION --}}
    <div style="margin-top:16px;">
        {{ $users->links() }}
    </div>
</div>

@endsection