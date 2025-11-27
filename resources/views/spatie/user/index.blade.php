@extends('layouts.admin')
@section('title','Usuarios')
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
                    <h4>Usuarios
                        <a href="{{route('users.create')}}" class="btn btn-primary float-end">Agregar Usuario</a>
                    </h4>
                </div>

                <div class="card-body">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Roles</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $rolename)
                                    <label class="badge bg-primary mx-1">{{$rolename}}</label>    
                                    @endforeach
                                        
                                    @endif
                                </td>
                                <td>
                                    {{-- <a href="{{url('roles/'.$role->id.'/give-permissions')}}" class="btn btn-success">Agregar/Editar Permisos</a> --}}

                                    <a href="{{url('users/'.$user->id.'/edit')}}" class="btn btn-warning">Editar</a>
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
