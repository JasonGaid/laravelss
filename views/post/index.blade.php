@extends('layouts.app')

@section('title', 'Post Data')

@section('contents')
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Post Data</h6>
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
              <th>Timestamp</th>
              <th>Action</th>
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
                <td>{{ $post->created_at }}</td>
                <td>
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $post->id }}">Delete</button>
                </td>
              </tr>
              <div class="modal fade" id="deleteModal{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Are you sure you want to delete this post?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                      <form id="deleteForm{{ $post->id }}" action="{{ route('post.delete', $post->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
    function deletePost(event, id) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: "{{ route('post.delete', '') }}" + "/" + id,
            data: {
                "_token": "{{ csrf_token() }}",
                "_method": "DELETE"
            },
            success: function() {
                location.reload();
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error('Error occurred while deleting:', errorThrown);
            }
        });
        return false;
    }
</script>
@endsection
