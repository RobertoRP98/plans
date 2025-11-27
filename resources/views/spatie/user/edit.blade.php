@extends('layouts.admin')
@section('title','Editar Usuario ' . $user->name)
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Editar Usuario
                        <a href="{{route('users.index')}}" class="btn btn-danger float-end">Regresar</a>
                    </h4>
                </div>

                <div class="card-body">

                    <form action="{{url('users/'.$user->id)}}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="">Nombre</label>
                            <input type="text" name="name" value="{{$user->name}}" class="form-control">
                            @error('name')
                               <span class="text-danger">{{$message}}</span> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="">Email</label>
                            <input type="text" name="email" value="{{$user->email}}" readonly class="form-control">
                             @error('email')
                               <span class="text-danger">{{$message}}</span> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="">Password</label>
                            <input type="text" name="password" class="form-control" placeholder="Si el password no cambia, deja en blanco este campo">
                             @error('password')
                               <span class="text-danger">{{$message}}</span> 
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="">Roles (manten presionado CTRL para seleccionar mas de un Rol)</label>
                            <select name="roles[]" class="form-control" multiple>
                                <option value="">Seleccionar Roles</option>
                                @foreach ($roles as $role )
                                    <option value="{{$role}}"
                                    {{in_array($role, $userRoles)? 'selected':''}}
                                    >
                                    {{$role}}</option>
                                @endforeach
                            </select>
                             @error('roles')
                               <span class="text-danger">{{$message}}</span> 
                            @enderror
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
