@extends('layouts.app')

@section('content')
    <h1>{{$label->id}}</h1>
    <h2>{{$label->name}}</h2>
    <h3>{{$label->created_at}}</h3>
@endsection
