@extends('layouts.admin')
@section('title','Crear Rol')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Crear Rol
                        <a href="{{route('roles.index')}}" class="btn btn-danger float-end">Regresar</a>
                    </h4>
                </div>

                <div class="card-body">

                    <form action="{{url('roles')}}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="">Nombre del Rol</label>
                            <input type="text" name="name" class="form-control">
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
