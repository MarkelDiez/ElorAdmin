@extends('layouts.app')
@section('content')


<div class="col-auto col-md-2 col-xl-2 px-sm-1 px-0 adminNav">
    <div class="d-flex flex-column  align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <li class="nav-item">
                <a href="/admin/departments"
                    class="nav-link align-middle px-0 {{ Request::is('admin/departments') ? 'active' : '' }}">
                    <i class="fs-4 bi-people"></i><span class="ms-1 d-none d-sm-inline">{{__('Departments')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/cycles"
                    class="nav-link align-middle px-0 {{ Request::is('admin/cycles') ? 'active' : '' }}">
                    <i class="fs-4 bi-journal"></i><span class="ms-1 d-none d-sm-inline">{{__('Cycles')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/modules"
                    class="nav-link align-middle px-0 {{ Request::is('admin/modules') ? 'active' : '' }}">
                    <i class="fs-4 bi-book"></i> <span class="ms-1 d-none d-sm-inline">{{__('Modules')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/roles"
                    class="nav-link align-middle px-0 {{ Request::is('admin/roles') ? 'active' : '' }}">
                    <i class="fs-4 bi-key"></i><span class="ms-1 d-none d-sm-inline">{{__('Roles')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/users"
                    class="nav-link align-middle px-0 {{ Request::is('admin/users') ? 'active' : '' }}">
                    <i class="fs-4 bi-person"></i> <span class="ms-1 d-none d-sm-inline">{{__('Users')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/cycleRegister"
                    class="nav-link align-middle px-0 {{ Request::is('admin/cycleRegister') ? 'active' : '' }}">
                    <i class="fs-4 bi-book"></i> <span class="ms-1 d-none d-sm-inline">{{__('Matriculate')}}</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="contentAdmin col-sm-8 col-md-9 col-xl-10 px-0">
    <!-- Contenido del área principal -->
    @yield('contenido')
</div>
<script>
    // JavaScript para resaltar el enlace activo
    document.addEventListener('DOMContentLoaded', function () {
        var currentUrl = window.location.pathname;
        console.log(currentUrl);
        var menuLinks = document.querySelectorAll('#menu .nav-link');

        menuLinks.forEach(function (link) {
            if (link.getAttribute('href') === currentUrl) {
                link.classList.add('active');
            }
        });
    });
</script>
@endsection