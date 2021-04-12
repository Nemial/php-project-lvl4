@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{__('task_status.show.page')}}: {{$taskStatus->name}}</h1>
    <p>{{__('task_status.show.id')}}: {{$taskStatus->id}}</p>
    <p>{{__('task_status.index.name')}}: {{$taskStatus->name}}</p>
@endsection
