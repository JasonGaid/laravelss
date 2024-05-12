@extends('layouts.app')

@section('title', isset($violation) ? 'Edit Violation' : 'Add Violation')

@section('contents')
  <form action="{{ isset($violation) ? route('violation.update', $violation->id) : route('violation.save') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ isset($violation) ? 'Edit Violation' : 'Add Violation' }}</h6>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="keyword">Keyword</label>
              <input type="text" class="form-control" id="keyword" name="keyword" value="{{ isset($violation) ? $violation->keyword : '' }}">
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('violation.index') }}" class="btn btn-secondary">Cancel</a>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection
