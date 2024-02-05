@extends('admin')
@section('contenido')
<div class="container-fluid">

    <h1 class="moduleTitle">{{__('UserWhitRol')}} : {{$role->name}}</h1>
    <ul>
    @foreach ($users as $user)
        <li>
            <p class="d-inline-flex d-inline-flex col-xl-3 col-md-3 col-sm-12">{{$user->dni}}: {{ $user->name }},
                {{$user->surname}}</p>
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

    @if ($customPaginator->lastPage() > 1)
        <nav>
            <ul class="pagination justify-content-center">
                {{-- Mostrar enlace para ir a la primera página --}}
                @if ($customPaginator->currentPage() != 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $customPaginator->url(1) }}" rel="first">
                            <i class="bi bi-arrow-bar-left"></i>
                            <span class="d-none d-sm-inline">1</span>
                        </a>
                    </li>
                @endif

                {{-- Mostrar enlace a la página anterior --}}
                @if ($customPaginator->onFirstPage())

                @elseif (!( $customPaginator->currentPage() - 1 == 1))
                    <li class="page-item">
                        <a class="page-link" href="{{ $customPaginator->previousPageUrl() }}" rel="prev">{{ $customPaginator->currentPage() - 1 }}</a>
                    </li>
                @endif

                {{-- Mostrar enlace a la página actual --}}
                <li class="page-item active">
                    <span class="page-link">{{ $customPaginator->currentPage() }}</span>
                </li>

                {{-- Mostrar enlace a la página siguiente --}}
                @if ($customPaginator->hasMorePages() && !( $customPaginator->currentPage() + 1 == $customPaginator->lastPage()))
                    <li class="page-item">
                        <a class="page-link" href="{{ $customPaginator->nextPageUrl() }}" rel="next">{{ $customPaginator->currentPage() + 1 }}</a>
                    </li>
                @endif

                {{-- Mostrar enlace para ir a la última página --}}
                @if ($customPaginator->currentPage() != $customPaginator->lastPage())
                    <li class="page-item">
                        <a class="page-link" href="{{ $customPaginator->url($customPaginator->lastPage()) }}" rel="last">
                            <span class="d-none d-sm-inline">{{ $customPaginator->lastPage() }}</span>
                            <i class="bi bi-arrow-bar-right"></i>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
    
</div>

@endsection