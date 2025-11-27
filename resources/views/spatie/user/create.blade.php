@extends('layouts.admin')
@section('title','Crear Usuario')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Crear Usuario
                        <a href="{{route('users.index')}}" class="btn btn-danger float-end">Regresar</a>
                    </h4>
                </div>

                <div class="card-body">

                    <form action="{{url('users')}}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="">Nombre</label>
                            <input type="text" name="name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="">Email</label>
                            <input type="text" name="email" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="">Password</label>
                            <input type="text" name="password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="">Roles (manten presionado CTRL para seleccionar mas de un Rol)</label>
                            <select name="roles[]" class="form-control" multiple>
                                <option value="">Seleccionar Roles</option>
                                @foreach ($roles as $role )
                                    <option value="{{$role}}">{{$role}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
