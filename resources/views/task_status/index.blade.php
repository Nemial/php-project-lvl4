@extends('layouts.app')

@section('content')
    <h1 class="mb-5">Task Statuses</h1>
    @auth()
        <a href="{{route('task_statuses.create')}}" class="btn btn-primary mb-2">{{__('index.create')}}</a>
    @endauth
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">{{__('index.id')}}</th>
            <th scope="col">{{__('index.name')}}</th>
            <th scope="col">{{__('index.created_at')}}</th>
            @auth()
                <th scope="col">{{__('index.action')}}</th>
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
                           class="text-primary">{{__('index.edit')}}</a>
                        <a href="{{route('task_statuses.destroy', $taskStatus->id)}}" class="text-danger"
                           data-method="delete" rel="nofollow" data-confirm="Are you sure?">{{__('index.delete')}}</a>
                    </td>
                @endauth
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
