@extends('admin')
@section('contenido')
<div class="container-fluid">

    <h1 class="moduleTitle">{{__('UserHaveModules')}} {{$module->name}} </h1>
    <ul>
    @foreach ($module->users as $user)
        <li>
            <p class="d-inline-flex d-inline-flex col-xl-3 col-md-3 col-sm-12">{{$user->dni}}, {{$user->surname}} {{$user->name}}</p>
            <div class="btnce d-inline-flex col-xl-2 col-md-3 col-sm-12">
                <a class="btn btn-primary btn-sm float-right" href="{{route('users.show',$user)}}" role="button">{{__('See')}}
                    <i class="bi bi-eye"></i></a>
            </div>
            <div class="btnce d-inline-flex d-inline-flex col-xl-2 col-md-3 col-sm-12">
                <p><a class="btn btn-warning btn-sm float-right" href="{{ route('users.edit', $user) }}"
                        role="button">{{__('Edit')}} <i class="bi bi-pencil"></i></a></p>
            </div>
            <form class="d-inline-flex d-inline-flex col-xl-2 col-md-3 col-sm-12"
                action="{{route('users.destroy',$user)}}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger" type="submit"
                    onclick="return confirm('¿Estas seguro?')">{{__('Delete')}} <i class="bi bi-trash3"></i></button>
            </form>
        </li>
    @endforeach
    </ul>
    
</div>

@endsection