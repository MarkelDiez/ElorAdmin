@extends('admin')
@section('contenido')

        <div class="container">
            <div class="form_div">
                <div class="title_div">
                    <h2 class="title">{{__('Roles')}}</h2>
                </div>
                <div class="labels_div">
                    <form class="" name="create"
                        action="@if (isset($role)) {{ route('roles.update', $role) }} @else {{ route('roles.store') }} @endif"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @if (isset($role))
                            @method('PUT')
                        @endif
                        <div class="form_input_div d-inline-flex">
                            <label for="name">{{__('RoleName')}} </label>
                            <input type="text" name="name" id="name" required value="{{ old('name', $role->name ?? '') }}" />
                        </div>
                        <div class="btnce d-inline-flex">
                        <button type="submit" class="btn btn-success btn-sm" name="">{{__('Save')}} <i class="bi bi-bookmark-check"></i></button>
        </div>
                    </form>
                </div>
            </div>
            <div class="list_div">
                <ol>
                    @foreach ($roles as $role)
                        <li>{{ $role->name }}</li>
                    @endforeach
                </ol>
            </div>
        </div>

@endsection
