@extends('layouts.admin')
@section('title','Roles')
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
                    <h4>Roles
                        <a href="{{route('roles.create')}}" class="btn btn-primary float-end">Agregar Rol</a>
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
                            @foreach ($roles as $role)
                            <tr>
                                <td>{{$role->id}}</td>
                                <td>{{$role->name}}</td>
                                <td>
                                    <a href="{{url('roles/'.$role->id.'/give-permissions')}}" class="btn btn-success">Agregar/Editar Permisos</a>

                                    <a href="{{url('roles/'.$role->id.'/edit')}}" class="btn btn-warning">Editar</a>
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
