@extends('admin')
@section('contenido')
<div class="container-fluid">
    <div class="form_div">    
        <div class="title_div">
            <h1 class="title">{{__('DepartmentUsers')}} {{$department->name}}:</h1>
        </div>
        <div class="list_div">
            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th scope="col">{{__('Surname')}}</th>
                        <th scope="col">{{__('Name')}}</th>
                        <th scope="col">{{__('Email')}}</th>
                        <th scope="col">{{__('Address')}}</th>
                        <th scope="col">{{__('Cycle')}}</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{$user->surname}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->address}}</td>
                        <td>
                            @if($user->cycles->isNotEmpty())
                                <?php $firstCycle = $user->cycles->first(); ?>
                                {{ $firstCycle->name }}
                            @else
                                {{__('NotMatriculed')}}
                            @endif
                        </td>
                    </tr>
                @empty
                <h2>{{__('NotUserAsigned')}}</h2>
                @endforelse
                </tbody>
            </table>
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
    </div>
</div>
@endsection