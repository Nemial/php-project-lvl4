@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{__('tasks.show.page')}}: {{$task->name}}</h1>
    <p>{{__('tasks.index.name')}}: {{$task->name}}</p>
    <p>{{__('tasks.show.status')}}: {{$task->status->name}}</p>
    <p>{{__('tasks.show.description')}}: {{$task->description}}</p>
    <p>{{__('tasks.show.labels')}}:</p>
    <ul>
        @foreach($task->labels as $label)
            <li>{{$label->name}}</li>
        @endforeach
    </ul>
@endsection
