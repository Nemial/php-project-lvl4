@extends('layouts.app')

@section('content')
    <h1 class="mb-5">Tasks</h1>
    <div class="mb-3">    {{Form::open(['url' => route('tasks.index'), 'method' => 'get', 'class' => 'form-inline'])}}
        <div class="form-group">
            {{Form::label('status_id', __('form.status'), ['class' => 'mr-1'])}}
            {{Form::select('filter[status_id]', $statuses, null, ['class' => 'form-control mr-2'])}}
        </div>
        <div class="form-group">
            {{Form::label('created_by_id', __('form.author'), ['class' => 'mr-1'])}}
            {{Form::select('filter[created_by_id]', $authors, null, ['class' => 'form-control mr-2'])}}
        </div>
        <div class="form-group">
            {{Form::label('assigned_to_id', __('form.executor'), ['class' => 'mr-1'])}}
            {{Form::select('filter[assigned_to_id]', $executors, null, ['class' => 'form-control mr-2'])}}
        </div>
        {{Form::submit(__('form.apply'))}}
        {{Form::close()}}</div>

    @auth()
        <a href="{{route('tasks.create')}}" class="btn btn-primary mb-2">{{__('tasks.index.create')}}</a>
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
                <td><a href="{{route('tasks.show', $task)}}">{{$task->name}}</a></td>
                <td>{{$task->status_id}}</td>
                <td>{{$task->created_by_id}}</td>
                <td>{{$task->assigned_to_id}}</td>
                <td>{{$task->created_at}}</td>
                @auth()
                    <td>
                        <a href="{{route('tasks.edit', $task->id)}}"
                           class="text-primary">{{__('tasks.index.edit')}}</a>
                        @can('delete', $task)
                            <a href="{{route('tasks.destroy', $task->id)}}" class="text-danger"
                               data-method="delete" rel="nofollow"
                               data-confirm="Are you sure?">{{__('tasks.index.delete')}}</a>
                        @endcan
                    </td>
                @endauth
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
