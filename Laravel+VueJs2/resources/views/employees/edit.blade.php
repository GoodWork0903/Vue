@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4 box-shadow">
                <div class="card-header">Редактирование сотрудника</div>
                <div class="card-body">
                    {!! Form::model($employee, ['method' => 'PUT', 'route' => ['employee.update', $employee->id]]) !!}
                        @include('employees._form', ['submitButtonText' => 'Обновить', 'class' => 'btn btn-warning'])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection