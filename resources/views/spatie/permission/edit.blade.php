@extends('layouts.admin')
@section('title','Editar Permiso ' . $permission->name)
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Editar Permiso
                        <a href="{{route('permissions.index')}}" class="btn btn-danger float-end">Regresar</a>
                    </h4>
                </div>

                <div class="card-body">

                    <form action="{{url('permissions/'.$permission->id)}}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="">Nombre del permiso</label>
                            <input type="text" name="name" value="{{$permission->name}}" class="form-control">
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
