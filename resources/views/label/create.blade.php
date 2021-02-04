@extends('layouts.app')

@section('content')
    {{Form::model($label, ['url' => route('labels.store')])}}
    @include('label.form')
    {{Form::submit(__('form.create'))}}
    {{Form::close()}}
@endsection
