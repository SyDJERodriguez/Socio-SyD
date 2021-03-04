@extends('layouts.application')
@section('content')
<!--BUTTONS AND PROGRESS ARROW-->
@include('includes.options', ['active' => 3])

<div style="padding-left: 3rem !important; padding-right: 3rem !important;">
   <hr>
   <div>
      <div style="padding-left: 10px !important;">
         <h6>Hola {{$data->name.' '.$data->last_name.' '.$data->second_last_name}}<br>
            No. de Cliente <span style="color:#009ce0">{{substr(Auth::user()->client_number, 2)}}</span>
         </h6>
         <hr>
      </div>
      <div>
      </div>
      <div style="padding-left: 10px !important;">
         <h5>Detalle de la cuenta</h5>
         </div>
   </div>
   <div>
      <div style="margin-left: 10px;">
         <div>
            <table class="table table-striped table-bordered" id="tableTrans" style="width:100%">
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
                        <th> {{ $trans->material_type }}</th>
                        <td> {{ $trans->sale_office }}</td>
                        <td>${{ $trans->amount }}</td>
                        <td> {{ $trans->payment_method }}</td>
                        <td> {{ $trans->quantity }}</td>
                        <td> {{ $trans->transaction_date }}</td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
            <div class="col-lg-12 text-justify text-primary leyenda">
               <p style="font-size:10px">
                  <b>Desliza hacia la derecha con el scroll inferior, para ver la tabla completa.<b>
               </p>
            </div>
         </div>
      </div>
      <br>
      <div class="row">
         <div class="col-4 mx-auto">
            <button class="btn btn-block text-white btn-alta" style="display: none" >DAR DE ALTA</button>
         </div>
      </div>
   </div>
   <br>
   <div class="row">
      <div class="col-12 ">
          <div class="col-md-6">
              <span class="float-left pl-2">
            <h4 style="color: #143153;"><strong>ACLARACIONES</strong></h4>
            <p>•	Para aclaraciones llámanos <br>
               al 800 SYD (793) 1010
            </p>
         </span>
          </div>
          <div class="col-md-12">
          @include('includes.Account.deleteButton')
          </div>
      </div>
   </div>
   <br><br><br><br>
</div>

<script>
   $('#tableTrans').DataTable({
      dom: 'Bfrtip',
      info: false,
      searching:false,
      scrollX:true,
      language: {
         paginate: {
            previous: "Anterior",
            next: "Siguiente"
         }
      },
      buttons: [
         {
            extend: 'excel',
            text: 'Excel',
            className: 'excel',
            exportOptions: {
                modifier: {
                    page: 'current'
                }
            }
        },
        {
            extend: 'print',
            text: 'Imprimir',
            className: 'print',
            exportOptions: {
                modifier: {
                    page: 'current'
                }
            }
        }
        ],
        language: {
            emptyTable: "No hay registros para mostrar"
        }
   });
</script>

@stop
