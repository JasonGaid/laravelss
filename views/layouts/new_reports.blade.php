@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">New Reports</h1>

    <!-- Reports Table -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Type</th>
                            <th>Flag</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Type</th>
                            <th>Flag</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr>
                                <td>{{ $report->id }}</td>
                                <td>{{ $report->user_id }}</td>
                                <td>{{ $report->type }}</td>
                                <td>{{ $report->flag }}</td>
                                <td>{{ $report->description }}</td>
                                <td>{{ $report->created_at }}</td>
                                <td>{{ $report->updated_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
