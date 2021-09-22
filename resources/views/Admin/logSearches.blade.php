@extends('layouts.admin')

@section('content')
    <div class="container">
      
            <div class="row justify-content-center">
                <div class="col-md-12">
                        <div style="display: flex; justify-content: space-between;">
                            <div class="col-md-8">
                                <h2>Registro de busquedas</h2>
                            </div>
                            <div class="col-md-4" style="display: flex; justify-content: flex-end;">
                                <a href="{{route('admin.customers.index')}}"
                                   class="btn btn-lg"
                                   style="background-color: rgb(0, 165, 230); color: rgb(255, 255, 255);">Regresar</a>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <h4></h4>
                        <table class="table table-striped table-bordered" id="logsSessions" style="width:100%">
                            <thead>
                            <tr>
                                <td><b>Usuario </b></td>
                                <td><b>Nombre</b></td>
                                <td><b>Fecha </b></td>
                                <td><b>Hora </b></td>
                                <td><b>Cliente Buscado</b></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($logSearches as $as)
                                <tr>
                                    <td>{{$as->user}}</td>
                                    <td>{{$as->name}}</td>
                                    <td>{{$as->date}}</td>
                                    <td>{{$as->time}}</td>
                                    <td>{{$as->wanted_client}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            
     
    </div>
  
@endsection