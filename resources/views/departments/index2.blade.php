@extends('homeNav')
@section('contenido')

<div class="pt-4 px-0">

    <div class="profesores">
        <div class="accordion" id="accordionExample">
            @foreach ($departments as $department)
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#{{ $department->name }}" aria-expanded="true"
                        aria-controls="{{ $department->name }}">
                        {{ $department->name }}
                    </button>
                </h2>
                <div id="{{ $department->name }}" class="accordion-collapse collapse"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">{{__('Surname')}}</th>
                                    <th scope="col">{{__('Name')}}</th>
                                    <th scope="col">{{__('Phone')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($department->users as $user)
                                <tr>
                                    <td>{{ $user->surname }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->phone }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection