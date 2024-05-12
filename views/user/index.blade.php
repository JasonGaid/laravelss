@extends('layouts.app')

@section('title', 'User Data')

@section('contents')
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">User Data</h6>
    </div>
    <div class="card-body">
      @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
          {{ Session::get('success') }}
        </div>
      @endif
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>User ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Status</th>
              <th>Report Count</th>
              <th>Timestamp</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @php($no = 1)
            @foreach ($users as $user)
              @if ($user->name !== 'admin')
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $user->id }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->status }}</td>
                  <td>{{ $user->report_count }}</td>
                  <td>{{ $user->created_at }}</td>
                  <td>
                    <form action="{{ route('activate.user', ['id' => $user->id]) }}" method="POST">
                      @csrf
                      <button type="submit" class="btn btn-primary">Activate</button>
                    </form>
                  </td>
                </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
