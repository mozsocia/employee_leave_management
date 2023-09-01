@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Leave Requests</h1>

    <div class="mb-3">
        <a href="{{ route('leaves.create') }}" class="btn btn-primary">Create New Leave Request</a>
    </div>

    @if ($leaves->isEmpty())
        <p>No leave requests yet.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leaves as $leave)
                    <tr>
                        <td>{{ $leave->category }}</td>
                        <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('Y-m-d') }}</td>
                        <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('Y-m-d') }}</td>
                        <td>{{ $leave->status }}</td>
                        <td>
                            <form action="{{ route('leaves.destroy', $leave) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $leaves->links() }}
    @endif
</div>
@endsection
