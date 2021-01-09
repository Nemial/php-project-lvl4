@extends('layouts.app')

@section('content')
    <h1 class="mb-5">Task Statuses</h1>
<table class="table table-striped">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Id</th>
        <th scope="col">Name</th>
        <th scope="col">Created At</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($taskStatuses as $taskStatus)
        <tr>
            <td scope="row">{{$taskStatus->id}}</td>
            <td scope="row">{{$taskStatus->name}}</td>
            <td scope="row">{{$taskStatus->created_at}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
