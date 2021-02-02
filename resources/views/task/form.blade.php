<div class="form-group">
    {{Form::label('name', 'Name')}}
    {{Form::text('name', null, ['class' => 'form-control'])}}
</div>
<div class="form-group">
    {{Form::label('description', 'Description')}}
    {{Form::textarea('description', null, ['class' => 'form-control'])}}
</div>
<div class="form-group">
    {{Form::label('status_id', 'Status')}}
    {{Form::select('status_id', $statuses, null, ['class' => 'form-control'])}}
</div>
<div class="form-group">
    {{Form::label('assigned_to_id', 'Executor')}}
    {{Form::select('assigned_to_id', $users, null, ['class' => 'form-control'])}}
</div>
