@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Leave List</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Leave ID</th>
                <th>User</th>
                <th>Category</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($leaves as $leave)
            <tr>
                <td>{{ $leave->id }}</td>
                <td>{{ $leave->user->name }}</td>
                <td>{{ $leave->category }}</td>
                <td>{{  \Carbon\Carbon::parse($leave->start_date)->format('Y-m-d') }}</td>
                <td>{{  \Carbon\Carbon::parse($leave->end_date)->format('Y-m-d') }}</td>
                <td>{{ $leave->status }}</td>
                <td>
                    <a href="{{ route('manager.leaves.edit', $leave) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('manager.leaves.destroy', $leave) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this leave?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
