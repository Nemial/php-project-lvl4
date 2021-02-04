@extends('layouts.app')

@section('content')
    {{Form::model($label, ['url' => route('labels.update', $label), 'method' => 'PATCH'])}}
    @include('label.form')
    {{Form::submit(__('form.edit'))}}
    {{Form::close()}}
@endsection
