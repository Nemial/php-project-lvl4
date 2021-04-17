<div class="form-group">
    {{Form::label('name', __('form.name'))}}
    {{Form::text('name', null, ['class' => 'form-control'])}}
</div>
<div class="form-group">
    {{Form::label('description', __('form.description'))}}
    {{Form::textarea('description', null, ['class' => 'form-control'])}}
</div>
<div class="form-group">
    {{Form::label('status_id', __('form.status'))}}
    {{Form::select('status_id', $statuses, null, ['class' => 'form-control', 'placeholder' => '------'])}}
</div>
<div class="form-group">
    {{Form::label('assigned_to_id', __('form.executor'))}}
    {{Form::select('assigned_to_id', $users, null, ['class' => 'form-control', 'placeholder' => '------'])}}
</div>
<div class="form-group">
    {{Form::label('labels', __('form.labels'))}}
    {{Form::select('labels[]', $labels, null, ['class' => 'form-control', 'multiple' => true])}}
</div>
