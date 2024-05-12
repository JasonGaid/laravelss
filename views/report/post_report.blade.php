@extends('layouts.app')

@section('title', 'Post Report')

@section('contents')
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Post Report</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>User ID</th>
              <th>Category ID</th>
              <th>Title</th>
              <th>Content</th>
              <th>Comments</th> <!-- New Column for Comments -->
              <th>Timestamp</th>
            </tr>
          </thead>
          <tbody>
            @php($no = 1)
            @foreach ($posts as $post)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $post->user_id }}</td>
                <td>{{ $post->category_id }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->content }}</td>
                <td>{{ $post->comments->count() }}</td> <!-- Display count of comments -->
                <td>{{ $post->created_at }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
