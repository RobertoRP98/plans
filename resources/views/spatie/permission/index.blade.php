@extends('layouts.admin')
@section('title','Permisos')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">

            @if (session('status'))
                <div class="alert alert-success">
                    {{session('status')}}
                </div>
            @endif

            @include('spatie.navroles')

            <div class="card mt-3">
                <div class="card-header">
                    <h4>Permisos
                        <a href="{{route('permissions.create')}}" class="btn btn-primary float-end">Agregar Permisos</a>
                    </h4>
                </div>

                <div class="card-body">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($permissions as $permission)
                            <tr>
                                <td>{{$permission->id}}</td>
                                <td>{{$permission->name}}</td>
                                <td>
                                    <a href="{{url('permissions/'.$permission->id.'/edit')}}" class="btn btn-warning">Editar</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
