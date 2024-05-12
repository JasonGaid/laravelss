@extends('layouts.app')

@section('title', 'Violation Data')

@section('contents')
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Violation Data</h6>
    </div>
    <div class="card-body">
      <a href="{{ route('violation.add') }}" class="btn btn-primary mb-3">Add Violation</a>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Keyword</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @php($no = 1)
            @foreach ($violations as $violation)
              <tr>
                <th>{{ $no++ }}</th>
                <td>{{ $violation->keyword }}</td>
                <td>
                  <a href="{{ route('violation.edit', $violation->id) }}" class="btn btn-warning">Edit</a>
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $violation->id }}">Delete</button>
                </td>
              </tr>
              <div class="modal fade" id="deleteModal{{ $violation->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Are you sure you want to delete this violation?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                      <form id="deleteForm{{ $violation->id }}" action="{{ route('violation.delete', $violation->id) }}" method="POST">
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
    function deleteViolation(event, id) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: "{{ route('violation.delete', '') }}" + "/" + id,
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
