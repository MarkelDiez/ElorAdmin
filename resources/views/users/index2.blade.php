@extends('homeNav')
@section('contenido')

<div class="pt-4 px-0">
    <div class="profesores">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">{{__('Surname')}}</th>
                    <th scope="col">{{__('Name')}}Nombre</th>
                    <th scope="col">{{__('Phone')}}</th>
                    <th scope="col">{{__('Email')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{$user->surname}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->email}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-end col space">
            {!! $users->links('vendor.pagination.default') !!}
        </div>
    </div>
</div>

@endsection