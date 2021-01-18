@extends('layouts.app')

@section('content')
    <h1>{{$taskStatus->id}}</h1>
    <h2>{{$taskStatus->name}}</h2>
    <h3>{{$taskStatus->created_at}}</h3>
@endsection
