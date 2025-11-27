@extends('layouts.admin')
@section('title','Editar Rol ' . $role->name)
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Editar Rol
                        <a href="{{route('roles.index')}}" class="btn btn-danger float-end">Regresar</a>
                    </h4>
                </div>

                <div class="card-body">

                    <form action="{{url('roles/'.$role->id)}}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="">Nombre del rol</label>
                            <input type="text" name="name" value="{{$role->name}}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
