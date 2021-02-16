@extends('layouts.application')
@section('content')
<!--BUTTONS AND PROGRESS ARROW-->
@include('includes.options', ['active' => 3])
<div class="container-fluid pr-5 pl-5" style="padding-left: 3rem !important; padding-right: 3rem !important;">
   <hr>
   <div class="row">
      <div class="col-lg-4 pl-5" style="padding-left: 15px !important;">
         <h4>Hola {{$data->name.' '.$data->last_name.' '.$data->second_last_name}}<br>
            No. de Cliente <span style="color:#009ce0">{{substr(Auth::user()->client_number, 2)}}</span>
         </h4>
         <hr>
      </div>
      <div class="col-lg-8">
      </div>
      <div class="col-lg-12 pl-5" style="padding-left: 15px !important;">
         <h4>Detalle de la cuenta</h4>
          <!--<div class="row">
             <div class="col-lg-3"><span>Saldo actual:</span></div>
             <div class="col-lg-3"><span>$2,500.00</span></div>
             <div class="col-lg-6"><span>Fecha de último movimiento:	</span><span>16 / AGO / 2020</span></div>
             <div class="col-lg-3"><span>Compras:</span></div>
             <div class="col-lg-3"><span>$1,800.00</span></div>
             <div class="col-lg-6"></div>
             <div class="col-lg-6">
                <h4 style="color: #143153;"><strong>Movimientos</strong></h4>
             </div>
             <div class="col-lg-6"><span class="float-right"><strong style="color: #143153;"><i class="fas fa-caret-right"></i>exportar</strong></span>
                <span class="float-right px-4" style="color: #143153;"><strong><i class="fas fa-caret-right"></i>Imprimir</strong></span>
             </div>
          </div>-->
       </div>
   </div>
   <div class="container-fluid py-4" style="overflow-y: scroll">
      <div class="row" >
         <div class="col-lg-12 mx-auto " >
            <table class="table">
               <thead>
                  <tr>
                     <!-- <th scope="col">Pieza</th> -->
                     <th scope="col">Familia</th>
                     <th scope="col">Oficina de Venta</th>
                     <!-- <th scope="col">SKU</th> -->
                     <th scope="col">Monto</th>
                     <th scope="col">Método de pago</th>
                     <th scope="col">Cantidad</th>
                     <th scope="col">Fecha</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($tr as $trans)
                     <tr>
                        <th>{{ $trans->material_type }}</th>
                        <td>{{ $trans->sale_office }}</td>
                        <td>{{ $trans->amount }}</td>
                        <td>{{ $trans->payment_method }}</td>
                        <td>{{ $trans->quantity }}</td>
                        <td>{{ $trans->transaction_date }}</td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
      <div class="row text-center" style="margin-top: -35px">
         <div class="col-12">
            <i class="fa fa-caret-down fa-3x"></i>
         </div>
      </div>
      <br>
      <div class="row">
         <div class="col-4 mx-auto">
            <button class="btn btn-block text-white btn-alta" >DAR DE ALTA</button>
         </div>
      </div>
   </div>
   <br>
   <div class="row">
      <div class="col-12 ">
         <span class="float-left pl-5">
            <h4 style="color: #143153;"><strong>ACLARACIONES</strong></h4>
            <p>•	Para aclaraciones llámanos <br>
               al 800 SYD (793) 1010
            </p>
         </span>
          @include('includes.Account.deleteButton')
      </div>
   </div>
   <br><br><br><br>
</div>

@stop
