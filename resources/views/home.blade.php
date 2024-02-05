@extends('layouts.app')
@section('content')

<div class="col-auto col-md-2 col-xl-2 px-sm-2 px-0 adminNav">
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <li class="nav-item">
                <a href="/departments" class="nav-link align-middle px-0">
                    <i class="fs-4 bi-people"></i><span class="ms-1 d-none d-sm-inline">{{__('Departments')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/cycles" class="nav-link align-middle px-0">
                    <i class="fs-4 bi-journal"></i><span class="ms-1 d-none d-sm-inline">{{__('Cycles')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/users" class="nav-link align-middle px-0">
                    <i class="fs-4 bi-person"></i> <span class="ms-1 d-none d-sm-inline">{{__('Users')}}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="contentAdmin col-auto col-sm-8 col-md-10 col-xl-10 px-sm-1 pt-4">

    <div class="container-fluid">
        <div class="form_div">
            <h1>{{__('StartInfo')}} {{ Auth::user()->name}} {{Auth::user()->surname}}</h1>
            {{--

            Apartado /home de los profesores

            --}}
            @if (!(Auth::user()->hasRole('Estudiante')))

            <h3>{{__('Department')}}: {{ Auth::user()->department->name }}</h3>
            <?php
                $mates = DB::table("users as s")
                    ->select('s.*')
                    ->where([['s.department_id', '=', Auth::user()->department_id]])
                    ->orderBy('surname', 'asc')
                    ->get();
                ?>
            <div class="accordion pt-2">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse" aria-expanded="false" aria-controls="collapse">
                            {{__('Coworker')}}
                        </button>
                    </h2>
                    <div id="collapse" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">{{__('Name')}}</th>
                                        <th scope="col">{{__('Surname')}}</th>
                                        <th scope="col">{{__('Email')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mates as $mate)
                                    <tr>
                                        <td>{{$mate->name}}</td>
                                        <td>{{$mate->surname}}</td>
                                        <td>{{$mate->email}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(Auth::user()->hasRole('Profesor'))

            <div class="accordion pt-2" id="cycleAccordion">
                @foreach($cycleName as $cycle)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $loop->index }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $loop->index }}" aria-expanded="true"
                            aria-controls="collapse{{ $loop->index }}">
                            {{ $cycle->name }}
                        </button>
                    </h2>
                    <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#cycleAccordion">
                        <div class="accordion-body">
                            <?php
                                    $modulesByCycle = DB::table("modules as m")->distinct()
                                        ->join('professor_cycle as pc', 'm.id', '=', 'pc.module_id')
                                        ->select('m.*')
                                        ->where([
                                            ['pc.cycle_id','=',$cycle->id],
                                            ['pc.user_id', '=', Auth::user()->id],
                                        ])
                                        ->get();
                                    ?>
                            @foreach($modulesByCycle as $module)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingModule{{ $module->id }}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseModule{{ $module->id }}" aria-expanded="true"
                                        aria-controls="collapseModule{{ $module->id }}">
                                        {{ $module->name }}
                                    </button>
                                </h2>
                                <div id="collapseModule{{ $module->id }}" class="accordion-collapse collapse"
                                    aria-labelledby="headingModule{{ $module->id }}"
                                    data-bs-parent="#collapse{{ $loop->index }}">
                                    <div class="accordion-body">
                                        <?php
                                                    $studentByModule = DB::table("cycle_register as cr")
                                                        ->join('modules as m', 'cr.module_id', '=', 'm.id')
                                                        ->join('users as u', 'cr.user_id', '=', 'u.id')
                                                        ->join('cycles as c', 'cr.cycle_id', '=', 'c.id')
                                                        ->select('cr.*', 'u.*')
                                                        ->where([
                                                            ['m.id','=',$module->id],
                                                            ['cr.cycle_id','=',$cycle->id],
                                                            ['cr.year', '=',now()->year],
                                                        ])
                                                        ->get();
                                                    ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">{{__('Name')}}</th>
                                                        <th scope="col">{{__('Surname')}}</th>
                                                        <th scope="col">{{__('Email')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($studentByModule as $student)
                                                    <tr>
                                                        <td>{{ $student->name }}</td>
                                                        <td>{{ $student->surname}}</td>
                                                        <td>{{ $student->email }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            {{--

            Apartado de /home de los estudiantes

            --}}
            @elseif(Auth::user()->hasRole('Estudiante'))
            <h3>{{__('Cycle')}}</h3>
            <!--TODO -->

            @if(count(Auth::user()->cycles) != 0)


            <?php $firstCycle = Auth::user()->cycles[0]; ?>
            <div class="accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse" aria-expanded="false" aria-controls="collapse">
                            {{ $firstCycle->name }}
                        </button>
                    </h2>
                    <div id="collapse" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">{{__('Modules')}}</th>
                                        <th scope="col">{{__('ProfessorName')}}</th>
                                        <th scope="col">{{__('Email')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($firstCycle->modules as $module)
                                    @php
                                    $cycleRegister = DB::table('cycle_register as cr')
                                    ->join('modules as m', 'cr.module_id', '=', 'm.id')
                                    ->select('cr.*', 'm.*')
                                    ->where([
                                    ['cr.user_id','=', Auth::user()->id],
                                    ['cr.cycle_id','=',$firstCycle->id],
                                    ['cr.module_id','=', $module->id],
                                    ['cr.year','=', now()->year]
                                    ])
                                    ->get()
                                    @endphp

                                    @foreach ($cycleRegister as $p)

                                    @php
                                    $teacher = DB::table('professor_cycle as pc')
                                    ->join('users as u', 'u.id','=','pc.user_id' )
                                    ->select('u.*')
                                    ->where([
                                    ['pc.module_id' ,'=',$p->module_id],
                                    ['pc.cycle_id','=',$p->cycle_id]
                                    ])
                                    ->first()
                                    @endphp

                                    <tr>
                                        <td>{{ isset($p->name) ? htmlspecialchars($p->name) : 'N/A' }}</td>
                                        @if($teacher == null)
                                        <td></td>
                                        <td></td>
                                        @else
                                        <td>{{ $teacher->name }}</td>
                                        <td>{{ $teacher->email }}</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="pt-4">{{__('RegistrationHistory')}}</h3>
            @php
            $historico = DB::table('cycle_register as cr')
            ->distinct()
            ->join('cycles as c', 'cr.cycle_id', '=', 'c.id')
            ->select('c.name', 'cr.year')
            ->where([
            ['cr.user_id','=', Auth::user()->id],
            ])
            ->orderBy('cr.year', 'desc')
            ->get()
            @endphp
            <table class="table table-bordered table-striped">
                <tr>
                    <th>{{__('Cycle')}}</th>
                    <th>{{__('RegistrationDate')}}</th>
                    <th>{{__('Curso')}}</th>
                </tr>
                @foreach ($historico as $h)
                <tr>
                    <td>{{$h->name}}</td>
                    <td>{{$h->year}}</td>
                    <td>
                        <?php 
                    $fechaCompleta = $h->year; // Suponiendo que $h->year tiene el formato 'Y-m-d'
                    $anyo = substr($fechaCompleta, 0, 4);?>
                        {{$anyo}}-{{$anyo+1}}
                    </td>
                </tr>
                @endforeach
            </table>
            @else
            <h3>{{__('NoRegistration')}}</h3>
            @endif
            @endif
        </div>
    </div>
</div>

@endsection