@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Detail Stuff</h2>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{ $stuff->name }}</h5>
        </div>
        <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted">Code: {{ $stuff->code }}</h6>
            <p class="card-text"><strong>Name:</strong> {{ $stuff->name }}</p>
            <p class="card-text"><strong>Created At:</strong> {{ $stuff->created_at }}</p>
            <p class="card-text"><strong>Updated At:</strong> {{ $stuff->updated_at }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ url('/stuffs') }}" class="btn btn-secondary">Back to List</a>
            <a href="{{ url('/stuffs/'.$stuff->id.'/edit') }}" class="btn btn-warning">Edit</a>
            <form action="{{ url('/stuffs/delete/'.$stuff->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
            </form>
        </div>
    </div>
</div>

@endsection
