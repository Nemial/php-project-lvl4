<div class="form-group">
    {{Form::label('name', __('form.name'))}}
    {{Form::text('name', null, ['class' => 'form-control'])}}
</div>
<div class="form-group">
    {{Form::label('description', __('form.description'))}}
    {{Form::textarea('description', null, ['class' => 'form-control'])}}
</div>
