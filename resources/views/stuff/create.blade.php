<!-- resources/views/stuff/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Create Stuff</h3>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/stuffs/store') }}" method="POST">
            @csrf
            <div class="form-group row mb-3">
                <label for="code" class="col-sm-2 col-form-label">Code</label>
                <div class="col-sm-10">
                    <input type="text" name="code" class="form-control" id="code" required>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ url('/stuffs/index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
