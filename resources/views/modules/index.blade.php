@extends('admin')
@section('contenido')
<div class="">
    <div class="div-btn-crear">
        <div class="btnce">
            <a class="btn btn-success btn-sm float-right" href="{{ route('modules.create') }}" role="button">Crear modulo <i class="bi bi-check-square"></i></a>
        </div>
    </div>
    <div class="infomacion">
        <h1>Listado de modulos</h1>
        <ul>
            @foreach ($modules as $module)
            <li><a href="/admin/modules/{{$module->id}}/edit">{{ $module->name }}</a></li>
            @endforeach
        </ul>
        <div class="paginacion">
            {{-- Mostrar enlace "Anterior" --}}
            @if ($customPaginator->onFirstPage())
                <span>Anterior</span>
            @else
                <a class="a_pagination" href="{{ $customPaginator->previousPageUrl() }}" rel="prev">Anterior</a>
            @endif

            {{-- Mostrar enlace "Siguiente" --}}
            @if ($customPaginator->hasMorePages())
                <a class="a_pagination" href="{{ $customPaginator->nextPageUrl() }}" rel="next">Siguiente</a>
            @else
                <span>Siguiente</span>
            @endif
        </div>
    </div>
</div>
@endsection