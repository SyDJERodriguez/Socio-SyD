@extends('layouts.application')
@section('content')
<!--BUTTONS AND PROGRESS ARROW-->
@include('includes.options', ['active' => 3])

<div style="padding-left: 3rem !important; padding-right: 3rem !important;">
   <hr>
   <div>
      <div style="padding-left: 10px !important;">

         @include('includes.accountData')

         @include('includes.opinionButton')
         <hr>
      </div>
      <div>
      </div>
      <div style="padding-left: 10px !important;">
         <h5>Detalle de la cuenta -
            {{ucfirst($data->mes->isoformat('MMMM'))}}
         </h5>
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
                     <th scope="col">Método de pago</th>
                     <th scope="col">Cantidad</th>
                     <th scope="col">Fecha</th>
                      <th scope="col">Monto</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($tr as $trans)
                  {{-- <p> {{VAR_DUMP($trans->client_number)}} </p> --}}
                  {{-- compare fecha de trans (mismo mes y negativo) y fecha actual --}}
                     <tr 
                        @if ( date('m', strtotime($trans->transaction_date) ) == date($data->mes->isoformat("MM")) 
                              && $trans->amount < 0 )
                        style='color: rgb(185, 185, 185)'
                        @endif
                        >
                        <th> {{ $trans->material_type }}</th>
                        <td> {{ $trans->sale_office }}</td>
                        <td> {{ $trans->payment_method }}</td>
                        <td> {{ $trans->quantity }}</td>
                        <td> {{ date_format(date_create($trans->transaction_date),'d-m-Y') }}</td>
                        <td>${{ number_format($trans->amount,2,'.',',') }}</td>
                     </tr>
                  @endforeach
               </tbody>
                <tfoot>
                <tr>
                    <th colspan="5" style="text-align:right">Total:</th>
                    <th></th>
                </tr>
                </tfoot>
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
               al 800 SyD (793) 1010
            </p>
         </span>
          </div>
      </div>
   </div>
   <br><br><br><br>
</div>

<script>
   $.noConflict();
   jQuery(document).ready(function($){
      $('#tableTrans').DataTable({
      dom: 'Bfrtip',
      info: false,
      searching:false,
      scrollX:true,
      oLanguage: {
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
        },
       "footerCallback": function ( row, data, start, end, display ) {
           var api = this.api(), data;
           let today = new Date();
           //today = today.getDate()+'-'+String(today.getMonth() + 1).padStart(2, '0')+'-'+today.getFullYear();
           today = today.getFullYear()+'-'+String(today.getMonth() + 1).padStart(2, '0')+'-'+(today.getDate());

           // Remove the formatting to get integer data for summation
           var intVal = function ( i ) {
               return typeof i === 'string' ?
                   i.replace(/[\$,]/g, '')*1 :
                   typeof i === 'number' ?
                       i : 0;
           };

           //only the dates after de actual date
           // Total over all pages
           total = api
               .data()//data[4] is date, data[5] is for price
               .filter( function (data) {
                     let fec = data[4].split('-');//get de date from colum 4
                     var fecha = new Date( fec[2],fec[1]-1,fec[0] );//set date to parse a new date
                     var hoy = new Date(today + " 00:00:00");

                     //added two days to the transactions date, and compare with current time
                     if( (new Date(fecha.getTime()) < (new Date(hoy.getTime()))) ){
                        //console.log( new Date(fecha.getTime() + (2 * 86400000)) )
                        console.log(hoy.getMonth() + 1) 
                        // encontrar una forma de que los valores negativso del mes pasado
                        // salgan en el siguiente mes mmm
                        console.log(data[5]) //string
                        return data
                     }

                  })
               .map( x => x[5])
               .reduce( function (a,b) {
                     return intVal(a) + intVal(b);
               },0 );
               //console.log(total)

               // Total over all pages (getted from another brach)
               /* total = api
               .column( 5 )
               .data()
               .reduce( function (a, b) {
                   return intVal(a) + intVal(b);
               }, 0 ); */

           // Total over this page
           /* pageTotal = api
               .column( 5, { page: 'current'} )
               .data()
               .reduce( function (a, b) {
                   return intVal(a) + intVal(b);
               }, 0 ); */

           // Update footer
           $( api.column( 5 ).footer() ).html(
               new Intl.NumberFormat('en-US',{ style: 'currency', currency: 'USD'}).format(total)
       );
       }
   });
   });

</script>

@stop
