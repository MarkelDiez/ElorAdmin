@extends('admin')
@section('contenido')
<div class="Rectangle6">
    <table class="userTable" style="">
        <tbody>
            <tr>
                <td style="font-weight: bold;">{{__('NAME')}} :</td>
                <td>{{$user->name}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">{{__('SURNAME')}} :</td>
                <td>{{$user->surname}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">{{__('BIRTHDATE')}} :</td>
                <td>{{$user->birthDate}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">{{__('UDNI')}} :</td>
                <td>{{$user->dni}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">{{__('PHONE')}} :</td>
                <td>{{$user->phone}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">{{__('EMAIL')}} :</td>
                <td>{{$user->email}}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">{{__('ADDRESS')}} :</td>
                <td>{{$user->address}}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="Rectangle6">
    <table class="table-with-padding table table-borderless">
        @foreach($user->cycles as $cycle)
        <p>{{$cycle->name}}</p>
        @foreach ($cycle->modules as $module)
        <p>{{$module->name}}</p>
        @endforeach
        @endforeach
    </table>
</div>
@endsection