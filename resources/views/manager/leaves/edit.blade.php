@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Leave</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <h5>Leave Details</h5>
    <p><strong>Leave Days:</strong> {{ $leave->leave_days }}</p>
    <p><strong>Total Leave Days for {{ $leave->user->name }}:</strong> {{ $leave->user->total_leave_days }}</p>
    <p><strong>Category:</strong> {{ $leave->category }}</p>
    <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($leave->start_date)->format('Y-m-d') }}</p>
    <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($leave->end_date)->format('Y-m-d') }}</p>
    <p><strong>Reason:</strong> {{ $leave->reason ?? 'N/A' }}</p>
    <p><strong>Total Leave Days for {{ $leave->user->name }}:</strong> {{ $leave->user->total_leave_days }}</p>




    <form action="{{ route('manager.leaves.update', $leave) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="status" class="form-label">Leave Status</label>
            <select name="status" id="status" class="form-select">
                @foreach($leave->getStatusOptions() as $value => $label)
                <option value="{{ $value }}" @if($leave->status === $value) selected @endif>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('manager.leaves.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
