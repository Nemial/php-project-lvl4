@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{__('labels.show.page')}}: {{$label->name}}</h1>
    <p>{{__('task_status.show.id')}}: {{$label->id}}</p>
    <p>{{__('task_status.index.name')}}: {{$label->name}}</p>
    <p>{{__('task.show.description')}}: {{$label->description}}</p>
@endsection
