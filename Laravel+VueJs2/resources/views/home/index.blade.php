@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-4 col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa fa-users"></i>
                    Сотрудники
                </div>
                <div class="card-body">
                    <p class="card-text">
                        <!-- counter of all created employees -->
                        @if($count_employees)
                            <b>{{ $count_employees }}</b>
                        @else
                            <b>0</b>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa fa-lock"></i>
                    Замки
                </div>
                <div class="card-body">
                    <p class="card-text">
                        <!-- counter of all created locks -->
                        @if($count_locks)
                            <b>{{ $count_locks }}</b>
                        @else
                            <b>0</b>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa fa-key"></i>
                    Свободные ключи
                </div>
                <div class="card-body">
                    <p class="card-text">
                        <!-- counter of all free keys -->
                        @if($free_keys)
                            <b>{{ $free_keys }}</b>
                        @else
                            <b>0</b>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!--main table component -->
    <div class="row">
        <div class="col-md-12">
            <main-table></main-table>
        </div>
    </div>

@endsection

