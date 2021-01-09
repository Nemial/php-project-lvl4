@extends('layouts.app')

@section('content')
    {{Form::model($taskStatus, ['url' => route('task_statuses.store')])}}
    @include('task_status.form')
    {{Form::submit('Create')}}
    {{Form::close()}}
@endsection
