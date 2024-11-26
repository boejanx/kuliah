@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Condensed Full Width Table</h3>
                    <a href="{{ url('/stuffs/create') }}" class="btn btn-primary btn-sm">Tambah</a>
                </div>
            </div> <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Task</th>
                            <th>Progress</th>
                            <th style="width: 40px">Label</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key=>$stuff)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $stuff->code }}</td>
                            <td>{{ $stuff->name }}</td>
                            <td>
                                <a href="{{url('/stuffs/'.$stuff->id)}}" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> show</a>
                                <a href="{{ url('/stuffs/'.$stuff->id.'/edit') }}" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Edit</a>
                                <form action="{{ url('/stuffs/delete'.$stuff->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.card-body -->
        </div> <!-- /.card -->
    </div>
</div>

@endsection
