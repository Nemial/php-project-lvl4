@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{__('labels.index.page_name')}}</h1>
    @auth()
        <a href="{{route('labels.create')}}" class="btn btn-primary mb-2">{{__('labels.index.create')}}</a>
    @endauth
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">{{__('labels.index.id')}}</th>
            <th scope="col">{{__('labels.index.name')}}</th>
            <th scope="col">{{__('labels.index.created_at')}}</th>
            @auth()
                <th scope="col">{{__('labels.index.action')}}</th>
            @endauth
        </tr>
        </thead>
        <tbody>
        @foreach ($labels as $label)
            <tr>
                <td>{{$label->id}}</td>
                <td>{{$label->name}}</td>
                <td>{{$label->created_at}}</td>
                @auth()
                    <td>
                        <a href="{{route('labels.edit', $label->id)}}"
                           class="text-primary">{{__('labels.index.edit')}}</a>
                        <a href="{{route('labels.destroy', $label->id)}}" class="text-danger"
                           data-method="delete" rel="nofollow"
                           data-confirm="Are you sure?">{{__('labels.index.delete')}}</a>
                    </td>
                @endauth
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
