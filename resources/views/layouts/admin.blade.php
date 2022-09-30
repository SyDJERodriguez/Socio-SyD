<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
     <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container" style="max-width: 1200px; padding: 0">
            <a class="navbar-brand" href="{{ url('/admin/index') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest

                        <!--<li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.register.form') }}">Registro</a>
                        </li>-->
                    @else
                        @if (Auth::user()->type_user==1)
                            <a class="nav-link " href="{{ route('admin.reports.index') }}">
                                Reportes
                            </a>
                        @endif
                        @if (Auth::user()->type_user == 1 || Auth::user()->type_user == 2 )
                        <a class="nav-link " href="{{ route('beneficiary.index') }}">
                                Registrar Beneficiarios
                        </a>
                        <a class="nav-link " href="{{ route('admin.search.index') }}">
                                Registrar Dependientes
                        </a>
                        @endif
                        @if (Auth::user()->type_user==1)
                            <a class="nav-link " href="{{ route('admin.total.registers') }}">
                                Registros
                            </a>
                            <a class="nav-link " href="{{ route('admin.consultLogSessions') }}">
                                Log Sesiones
                            </a>
                            <a class="nav-link " href="{{ route('admin.consultLogSearches') }}">
                                Log Busquedas
                            </a>
                        @endif

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

<script>
    /*$(document).ready( function () {
        $('.datatable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf','csv'
            ]
        });
    });*/

    let buttons  = document.querySelector('#buttonconf');
    let mobileInput  = document.querySelector('#mobileuser');
    let inputCodes = document.querySelector('#codes');
    let requiredCodes = document.querySelector('#requiredSignal');
    let hostName     = window.location.origin+"/send_sms_verification/";
    let codeConfir  = document.querySelector('#codesConfirm');

        buttons.addEventListener('click', function (){

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            console.log(this.response)
            if (this.readyState == 4 && this.status == 200) {
                codeConfir.value = this.response;
            }
        };

        let url = hostName+mobileInput.value;
        xhttp.open("GET", url, true);
        xhttp.send();

        requiredCodes.hidden = false;
       // setTimeout(() =>{alertCode.hidden = true},3500);
        inputCodes.type = 'text';
    });
</script>

@yield('scripts')

</body>
</html>

<script>
$.noConflict();
jQuery(document).ready(function($){

    $(document).ready(function () {
        $('body').on('click', '#edit_beneficiary', function (event) {

            event.preventDefault();
            let id = $(this).data('id');
            let client_number = $(this).data('client_number_r');
            let name = $(this).data('name');
            let last_name = $(this).data('last_name_r');
            let second_last_name = $(this).data('second_last_name_r');
            let email = $(this).data('email');
            let phone = $(this).data('phone');
            let gender = $(this).data('gender');
            let birthday = $(this).data('birthday');
            let benefit = $(this).data('benefit');
            let report_id = $(this).data('report_id_r');
            let rfc_r = $(this).data('rfc_r');

            $('#client_number_r').val(client_number);
            $('#name_r').val(name);
            $('#last_name_r').val(last_name);
            $('#second_last_name_r').val(second_last_name);
            $('#email_r').val(email);
            $('#phone_r').val(phone);
            $('#gender_r').val(gender);
            $('#birthday_r').val(birthday);
            $('#benefit_r').val(benefit);
            $('#id_r').val(id);
            $('#report_id_r').val(report_id);
            $('#rfc_r').val(rfc_r);
            /*$.get('color/' + id + '/edit', function (data) {
                $('#userCrudModal').html("Edit category");
                $('#submit').val("Edit category");
                $('#practice_modal').modal('show');
                $('#color_id').val(data.data.id);
                $('#name').val(data.data.name);
            })*/
        });
    });

   $('#logsSessions').DataTable({
       "order": [[ 2, "desc" ],[ 3, "desc" ]],
       dom: 'Bfrtip',
       info: false,
       searching:true,
       scrollX:true,
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
   "language":
        {
            "zeroRecords":"No hay registros para mostrar",
            "infoEmpty": "No hay registros para mostrar",
            "emptyTable": "No hay registros para mostrar",
            "search":"Buscar:",
            "paginate":
            {
              'previous': "Anterior",
              'next': "Siguiente"
            },
        }

    });

    $('#logsReports').DataTable({
        "order": [[ 2, "desc" ],[ 3, "desc" ]],
        dom: 'Bfrtip',
        info: false,
        searching:true,
        scrollX:true,
        buttons: [],
        "language":
            {
                "zeroRecords":"No hay registros para mostrar",
                "infoEmpty": "No hay registros para mostrar",
                "emptyTable": "No hay registros para mostrar",
                "search":"Buscar:",
                "paginate":
                    {
                        'previous': "Anterior",
                        'next': "Siguiente"
                    },
            }

    });

    $('#detailReport').DataTable({
        dom: 'Bfrtip',
        info: false,
        searching:true,
        buttons: [],
        scrollY: '700px',
        scrollCollapse: true,
        paging: false,
        "language":
            {
                "zeroRecords":"No hay registros para mostrar",
                "infoEmpty": "No hay registros para mostrar",
                "emptyTable": "No hay registros para mostrar",
                "search":"Buscar:",
                "paginate":
                    {
                        'previous': "Anterior",
                        'next': "Siguiente"
                    },
            }

    });
    $("#addEmployesearch").bind("submit",function(){
            // We capture send button
            let Sendbtn = $("#Sendbtn");
            let alerterrortext  = document.querySelector("#form_alert_phone_text_search");
            let alerterrordns  = document.querySelector("#form_alert_dns_search");
            let inputCodes = document.querySelector('#codes');
            let codeConfir  = document.querySelector('#codesConfirm');
            let error_code       = document.querySelector('#error_code_br');
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data:$(this).serialize(),
                beforeSend: function(){
                    Sendbtn.html("Enviando");
                    Sendbtn.attr("disabled",true);
                },
                success: function(data){
                   // console.log(data);
                    Sendbtn.html("Aceptar");
                    Sendbtn.attr("disabled",false);
                    if(codeConfir.value === codes.value) {
                    if(data['success']==='false' && data['verify_valid_mobile']==='false'){
                        alerterrortext.innerHTML='<div style="border: 1px solid black" class="input-group-text bg-danger text-white"> X </div>';
                        alerterrortext.removeAttribute("hidden");
                        setTimeout(function (){alerterrortext.hidden= true}, 3500);
                        alerterrortext.innerHTML='<p style="margin-bottom:0px">El número telefónico no es válido. Verifica tus datos</p>';
                        alerterrortext.removeAttribute("hidden");
                        setTimeout(function(){alerterrortext.hidden = true},3500)
                    }else if(data['success']==='false' && data['verify_valid_dns']==='false'){
                        alerterrordns.innerHTML='<p style="margin-bottom:0px">Por favor proporciona un email válido</p>';
                        alerterrordns.removeAttribute("hidden");
                        setTimeout(function(){alerterrordns.hidden = true},3500)
                    }else if(data['success']==='false' && data['other']==='false'){
                        alerterrordns.innerHTML='<p style="margin-bottom:0px">'+data['error']+'</p>';
                        alerterrordns.removeAttribute("hidden");
                        setTimeout(function(){alerterrordns.hidden = true},3500)
                    }else if(data['success']==='false' && data['bday']==='false'){
                        alerterrordns.innerHTML='<p style="margin-bottom:0px">'+data['error']+'</p>';
                        alerterrordns.removeAttribute("hidden");
                        setTimeout(function(){alerterrordns.hidden = true},3500)

                    }else{
                        window.location = "{{route('addsuccess')}}";
                    }
                }else{
                console.log('Not are the same code');
                error_code.innerHTML = 'El código de verificación es incorrecto';
                error_code.hidden    = false;
                setTimeout(() =>{error_code.hidden = true},3500);
                return false;
            }
                },
                error: function(data){
                    $('#modalErrorServer').modal('show');
                }

            });
            // Nos permite cancelar el envio del formulario
            return false;
        });

});
</script>
