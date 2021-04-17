@extends('layouts.app')

@section('content')
    <h1 class="mb-5">@lang('tasks.index.page_name')</h1>
    <div class="mb-3">    {{Form::open(['url' => route('tasks.index'), 'method' => 'get', 'class' => 'form-inline'])}}
        <div class="form-group">
            {{Form::select('filter[status_id]', $statuses, $filter['status_id'] ?? '', ['class' => 'form-control mr-2', 'placeholder' => __('tasks.index.status_id')])}}
        </div>
        <div class="form-group">
            {{Form::select('filter[created_by_id]', $users, $filter['created_by_id'] ?? '', ['class' => 'form-control mr-2', 'placeholder' => __('tasks.index.executor')])}}
        </div>
        <div class="form-group">
            {{Form::select('filter[assigned_to_id]', $users, $filter['assigned_to_id'] ?? '', ['class' => 'form-control mr-2', 'placeholder' => __('tasks.index.author')])}}
        </div>
        {{Form::submit(__('form.apply'))}}
        {{Form::close()}}</div>

    @auth()
        <a href="{{route('tasks.create')}}" class="btn btn-primary mb-2">@lang('tasks.index.create')</a>
    @endauth
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">@lang('tasks.index.id')</th>
            <th scope="col">@lang('tasks.index.name')</th>
            <th scope="col">@lang('tasks.index.status_id')</th>
            <th scope="col">@lang('tasks.index.author')</th>
            <th scope="col">@lang('tasks.index.executor')</th>
            <th scope="col">@lang('tasks.index.created_at')</th>
            @auth()
                <th scope="col">@lang('tasks.index.action')</th>
            @endauth
        </tr>
        </thead>
        <tbody>
        @foreach ($tasks as $task)
            <tr>
                <td>{{$task->id}}</td>
                <td><a href="{{route('tasks.show', $task)}}">{{$task->name}}</a></td>
                <td>{{$task->status->name ?? ''}}</td>
                <td>{{$task->author->name}}</td>
                <td>{{$task->executor->name ?? ''}}</td>
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
