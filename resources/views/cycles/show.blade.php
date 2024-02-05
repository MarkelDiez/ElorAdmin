@extends('admin')
@section('contenido')
<div class="container-fluid">

    <h1 class="moduleTitle">{{__('Modules')}} : {{$cycle->name}}</h1>

    <div class="modulos">
        @foreach ($cycle->modules as $modules)
        <div class="modulo-item">
            <p>{{$modules->name}}</p>
        </div>
        @endforeach
    </div>
    <div class="profesores">

        <table>
            <thead>
                <tr>
                    <th scope="col">{{__('Name')}}</th>
                    <th scope="col">{{__('Email')}}</th>
                    <th scope="col">{{__('DNI')}}</th>
                    <th scope="col">{{__('See')}}</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($cycle->profesores as $user)
            
                    <tr>
                        <td>{{$user->surname}}, {{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->dni}}</td>
                        <td>
                            <div class="btnce d-inline-flex col-xl-2 col-md-3 col-sm-12">
                                <a class="btn btn-primary btn-sm float-right" href="{{route('users.show',$user)}}"
                                    role="button">{{__('See')}}
                                    <i class="bi bi-eye"></i></a>
                            </div>
                        </td>
                    </tr>
                   
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection