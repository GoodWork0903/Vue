@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Редактирование замка</div>
                <div class="card-body">
                    {!! Form::model($lock, ['method' => 'PUT', 'route' => ['lock.update', $lock->id]]) !!}
                        @include('locks._form', ['submitButtonText' => 'Обновить', 'class' => 'btn btn-warning'])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection