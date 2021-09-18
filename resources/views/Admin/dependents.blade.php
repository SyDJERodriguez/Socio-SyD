@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-white bg-dark">Buscar Socio</div>
                    <br>
                    <div class="row">
                        <div class="col-md-10 py-2" style="padding-left: 33px">
                            <label><b>Selecciona un socio por su nombre o por su correo electrónico</b></label>
                        </div>
                        <div class="col-md-2 py-2" style="justify-content: flex-end;">
                            <a href="javascript:history.back()"
                               class="btn btn-sm"
                               style="background-color: rgb(0, 165, 230); color: rgb(255, 255, 255);">Regresar</a>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- <div class="row"> --}}
                            {{-- <div class="col-md-12" style="display: flex; justify-content: center;"> --}}
                                {{-- <form method="GET" action="{{route('admin.search.client.number')}}"> --}}
                                @if ( isset($dependents) )
                                    @foreach ($dependents as $d)

                                       <div class="row">
                                            <div class="col-md-6">
                                                <p>
                                                    <a href=" {{url('admin/'.$d->id)}} ">
                                                        {{ $d->name ." ". $d->last_name ." ". $d->second_last_name  }}
                                                    </a>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p> {{ $d->email }} </p>
                                            </div>
                                       </div>
                                        
                                    @endforeach
                                @endif
                                   
                            {{-- </div> --}}

                        {{-- </div> --}}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
