@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Edit Stuff</h2>

    <form action="{{ url('/stuffs/update/'.$stuff->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Menggunakan PUT untuk update -->

        <div class="form-group row mb-3">
            <label for="code" class="col-sm-2 col-form-label">Code</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="code" name="code" value="{{ old('code', $stuff->code) }}" required>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $stuff->name) }}" required>
            </div>
        </div>

        <div class="form-group mb-3">
            <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ url('/stuffs') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>

@endsection
