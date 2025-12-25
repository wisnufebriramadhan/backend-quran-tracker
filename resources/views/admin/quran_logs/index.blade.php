@extends('admin.layout')

@section('content')
<h2>Quran Logs</h2>

<div class="card">
    <table width="100%" cellpadding="10" cellspacing="0">
        <thead style="text-align:left;">
            <tr>
                <th>User</th>
                <th>Date</th>
                <th>Surah</th>
                <th>Ayat</th>
                <th>Duration</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
            <tr>
                <td>{{ $log->user->email ?? '-' }}</td>
                <td>{{ $log->date }}</td>
                <td>{{ $log->surah }}</td>
                <td>{{ $log->ayat_from }} - {{ $log->ayat_to }}</td>
                <td>{{ $log->duration ?? '-' }} min</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;color:#888;">
                    No Quran logs found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:16px;">
    {{ $logs->links() }}
</div>
@endsection