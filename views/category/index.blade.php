@extends('layouts.app')

@section('title', 'Data Category')

@section('contents')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Category</h6>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
        <a href="{{ route('category.add') }}" class="btn btn-primary mb-3">Add Category</a>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php($no = 1)
                    @foreach ($category as $row)
                    <tr>
                        <th>{{ $no++ }}</th>
                        <td>{{ $row->name }}</td>
                        <td>
                            <a href="{{ route('category.edit', $row->id) }}" class="btn btn-warning">Edit</a>
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                data-target="#deleteModal{{ $row->id }}">Delete</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="deleteModal{{ $row->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this category?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <form id="deleteForm{{ $row->id }}"
                                        action="{{ route('category.delete', $row->id) }}" method="POST">
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
    function deleteCategory(event, id) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: "{{ route('category.delete', '') }}" + "/" + id,
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
