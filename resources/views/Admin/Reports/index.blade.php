@extends('layouts.admin')

@section('content')
    <div class="container" style="max-width: 90%">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div style="display: flex; justify-content: space-between;">
                    <div class="col-md-6">
                        <h2>Reportes Asistencias y Seguros</h2>
                    </div>
                    <div class="col-md-6" style="display: flex; justify-content: flex-end;">
                        <div class="col-md-6" style="max-width: 30%">
                            <a href="{{route('admin.reports.create.telasist')}}"
                               class="btn"
                               style="background-color: rgb(0, 165, 230); color: rgb(255, 255, 255);">Generar reporte Telasist</a>
                        </div>
                        <div class="col-md-6" style="max-width: 30%">
                            <a href="#"
                               class="btn"
                               style="background-color: rgb(0, 165, 230); color: rgb(255, 255, 255);">Generar reporte Chubb</a>
                        </div>
                    </div>

                </div>
                <hr>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <h4></h4>
                        <table class="table table-striped table-bordered" id="logsReports" style="width:100%" >
                            <thead>
                            <tr>
                                <td><b># </b></td>
                                <td><b>Tipo</b></td>
                                <td><b>ID</b></td>
                                <td><b>Estatus </b></td>
                                <td><b>Fecha Creación </b></td>
                                <td><b>Autor </b></td>
                                <td><b>Fecha Aprobación </b></td>
                                <td><b>Aprobado Por </b></td>
                                <td><b>Opciones </b></td>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $report)
                                    <tr>
                                        <td>{{$report->id}}</td>
                                        <td>{{$report->type_report}}</td>
                                        <td>{{$report->report_id}}</td>
                                        <td>
                                            @if('1' === $report->status)
                                                Creado
                                            @elseif('2' === $report->status)
                                                Revisado
                                            @else
                                                Aprobado
                                            @endif
                                        </td>
                                        <td>{{$report->created_date}}</td>
                                        <td>{{$report->created_by}}</td>
                                        <td>{{$report->approved_date}}</td>
                                        <td>{{$report->approved_by}}</td>
                                        <td>
                                            <a href="{{url('admin/reports/detailReport/'.$report->report_id)}}" class="btn btn-warning btn-sm">Detalle</a>
                                            @if( '1' === $report->status || '2' === $report->status )
                                                <a href="#" class="btn btn-success btn-sm">Aprobar</a>
                                            @else
                                                <button href="#" class="btn btn-success btn-sm" disabled>Aprobar</button>
                                            @endif

                                            @if( '1' === $report->status || '2' === $report->status )
                                                <button class="btn btn-primary btn-sm" disabled>Descargar</button>
                                            @else
                                                <a href="#" class="btn btn-primary btn-sm">Descargar</a>
                                            @endif
                                            <a href="#" class="btn btn-danger btn-sm">Eliminar</a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--<ul class="nav nav-tabs">
                    <li class="nav-item">
                        <button style="color: #212529" class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Chubb</button>
                    </li>
                    <li class="nav-item" >
                        <button style="color: #212529" class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Telasist</button>
                    </li>
                    <li class="nav-item" >
                        <button style="color: #212529" class="nav-link" id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Log</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">Home</div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">Profile</div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">Contact</div>
                </div>-->
            </div>
        </div>
    </div>
@endsection
