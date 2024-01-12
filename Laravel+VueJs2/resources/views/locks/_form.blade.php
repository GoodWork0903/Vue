@include('errors.errors')
<div class="form-group">
    <label for="title" class="control-label">
        Название <span class="text-danger">*:</span>
    </label>
    {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
</div>
<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => $class, 'style' => 'color:white;']) !!}
    <a class="btn btn-secondary" href="{{ route('lock.index') }}">
        Отменить
    </a>
</div>