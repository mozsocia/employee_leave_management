@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('Dashboard') }}</div>

          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif

            <h1>Thank you for Your Time</h1>
            <h4>Your Total Leave Days : {{ Auth::user()->total_leave_days }}</h4>
              <hr><br>
            <div class="row mb-3">
              <div class="col-md-12">
                @auth
                  <a href="{{ route('leaves.index') }}" class="btn btn-primary">View Leaves</a>
                  <a href="{{ route('leaves.create') }}" class="btn btn-success">Create Leave</a>
                @endauth
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-12">
                @auth
                  @if (Auth::user()->hasRole('manager'))
                    <a href="{{ route('manager.leaves.index') }}" class="btn btn-primary">View Leaves of all Employee</a>
                  @endif
                @endauth
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
