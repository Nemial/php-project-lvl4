@extends('layouts.app')

@section('content')
    {{Form::model($taskStatus, ['url' => route('task_statuses.update', $taskStatus), 'method' => 'PATCH'])}}
    @include('task_status.form')
    {{Form::submit(__('form.edit'))}}
    {{Form::close()}}
@endsection
