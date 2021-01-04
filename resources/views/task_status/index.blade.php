@extends('layouts.app')

@section('content')
    <h1>Список статусов</h1>
    @foreach ($taskStatuses as $taskStatus)
        <h2>{{$taskStatus->name}}</h2>
    @endforeach
@endsection
