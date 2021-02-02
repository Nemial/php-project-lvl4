@extends('layouts.app')

@section('content')
    {{Form::model($task, ['url' => route('tasks.store')])}}
    @include('task.form')
    {{Form::submit(__('form.create'))}}
    {{Form::close()}}
@endsection
