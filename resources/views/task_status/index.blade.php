@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{__('task_status.index.page_name')}}</h1>
    @auth()
        <a href="{{route('task_statuses.create')}}" class="btn btn-primary mb-2">{{__('task_status.index.create')}}</a>
    @endauth
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">{{__('task_status.index.id')}}</th>
            <th scope="col">{{__('task_status.index.name')}}</th>
            <th scope="col">{{__('task_status.index.created_at')}}</th>
            @auth()
                <th scope="col">{{__('task_status.index.action')}}</th>
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
                        <a href="{{route('task_statuses.edit', $taskStatus->id)}}"
                           class="text-primary">{{__('task_status.index.edit')}}</a>
                        <a href="{{route('task_statuses.destroy', $taskStatus->id)}}" class="text-danger"
                           data-method="delete" rel="nofollow"
                           data-confirm="Are you sure?">{{__('task_status.index.delete')}}</a>
                    </td>
                @endauth
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
