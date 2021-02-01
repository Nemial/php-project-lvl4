@extends('layouts.app')

@section('content')
    <h1 class="mb-5">Tasks</h1>
    @auth()
        <a href="{{route('task_statuses.create')}}" class="btn btn-primary mb-2">{{__('task_status.index.create')}}</a>
    @endauth
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">{{__('tasks.index.id')}}</th>
            <th scope="col">{{__('tasks.index.name')}}</th>
            <th scope="col">{{__('tasks.index.status_id')}}</th>
            <th scope="col">{{__('tasks.index.author')}}</th>
            <th scope="col">{{__('tasks.index.executor')}}</th>
            <th scope="col">{{__('tasks.index.created_at')}}</th>
            @auth()
                <th scope="col">{{__('tasks.index.action')}}</th>
            @endauth
        </tr>
        </thead>
        <tbody>
        @foreach ($tasks as $task)
            <tr>
                <td>{{$task->id}}</td>
                <td>{{$task->name}}</td>
                <td>{{$task->created_at}}</td>
                @auth()
                    <td>
                        <a href="{{route('tasks.edit', $task->id)}}"
                           class="text-primary">{{__('tasks.index.edit')}}</a>
                        <a href="{{route('tasks.destroy', $task->id)}}" class="text-danger"
                           data-method="delete" rel="nofollow"
                           data-confirm="Are you sure?">{{__('tasks.index.delete')}}</a>
                    </td>
                @endauth
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
