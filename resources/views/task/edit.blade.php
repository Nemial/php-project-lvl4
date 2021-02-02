@extends('layouts.app')

@section('content')
    {{Form::model($task, ['url' => route('tasks.update', $task), 'method' => 'PATCH'])}}
    @include('task.form')
    {{Form::submit(__('form.edit'))}}
    {{Form::close()}}
@endsection
