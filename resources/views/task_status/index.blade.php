@extends('layouts.app')

@section('content')
    <h1 class="mb-5">Task Statuses</h1>
<table class="table table-striped">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Id</th>
        <th scope="col">Name</th>
        <th scope="col">Created At</th>
        @auth()
            <th scope="col">Action</th>
        @endauth
    </tr>
    </thead>
    <tbody>
    @foreach ($taskStatuses as $taskStatus)
        <tr>
            <td>{{$taskStatus->id}}</td>
            <td>{{$taskStatus->name}}</td>
            <td>{{$taskStatus->created_at}}</td>
            @auth()
                <td>
                    <a href="{{route('task_statuses.edit', $taskStatus->id)}}" class="text-primary">Edit</a>
                    <a href="{{route('task_statuses.destroy', $taskStatus->id)}}" class="text-danger" data-method="delete" rel="nofollow" data-confirm="Are you sure?">Delete</a>
                </td>
            @endauth
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
