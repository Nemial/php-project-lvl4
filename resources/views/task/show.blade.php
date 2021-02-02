@extends('layouts.app')

@section('content')
    <h1>{{$task->id}}</h1>
    <h2>{{$task->name}}</h2>
    <h3>{{$task->created_at}}</h3>
@endsection
