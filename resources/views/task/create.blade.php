@extends('layouts.app')

@section('content')
    {{Form::model($task, ['url' => route('task_statuses.store')])}}
    @include('task_status.form')
    {{Form::submit(__('form.create'))}}
    {{Form::close()}}
@endsection
