@include('errors.errors')

<div class="form-group">
    <label for="name" class="control-label">
        ФИО <span class="text-danger">*:</span>
    </label>
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
</div>
<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => $class, 'style' => 'color:white;']) !!}
    <a class="btn btn-secondary" href="{{ route('employee.index') }}">
        Отменить
    </a>
</div>