@extends('admin')
@section('contenido')

<div class="container-fluid">
    <div class="form_div">
        <div class="title_div">
            <h2 class="title">{{$cycle->name}}</h2>
        </div>
        <div class="labels_div">
            <form class="" name="create"
                action="@if (isset($cycle)) {{ route('cycles.update', $cycle) }} @else {{ route('cycles.store') }} @endif"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($cycle))
                @method('PUT')
                @endif
                <div class="row form_input_div d-inline-flex col-xl-12 col-md-12 col-sm-12 col-form-label">
                    <label class="col-form-label" for="name">Nombre de ciclo</label>
                    <input class="form-control" value="{{$cycle->name}}" type="text" name="name" id="name" required/>
                </div>
                <div class="row form_input_div d-inline-flex col-xl-12 col-md-12 col-sm-12 col-form-label">
                    <label class="col-form-label" for="department_id">Departamento asociado</label>
                    <select class="form-control" name="department_id">
                        @foreach ($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="btnce d-inline-flex">
                        <button type="submit" class="btn btn-success btn-sm" name="">Guardar <i class="bi bi-bookmark-check"></i></button>
                </div>
            </form>
        </div>
    </div>
    <h3>Listado de ciclos</h3>
    <div class="list_div">
        <ul>
            @foreach ($cycles as $cycle)
            <li>{{ $cycle->name }}</li>
            @endforeach
        </ul>
    </div>
</div>

@endsection