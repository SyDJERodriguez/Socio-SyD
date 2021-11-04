<h6>Hola {{$owner}}<br>
    No. de Cliente <span style="color:#009ce0">{{substr(Auth::user()->client_number, 2)}}
     @if(Auth::user()->client_type == '3')
         - {{$number->number}}
     @endif
     @if (Auth::user()->client_type=='4')
         - {{ $data->branch_number }}
     @endif
 </span><br>

     @switch((int)Auth::user()->client_type)
         @case(1)
         Cuenta: Con Colaboradores
             @break
         @case(2)
         Cuenta: Individual
             @break
         @case(3)
         Cuenta: Dependiente
             @break
         @case(4)
         Cuenta: Sucursal ({{ $data->branch_name }})
             @break
        @case(5)
            Cuenta: Público General
            @break
         @default
             Cuenta:
     @endswitch
 </h6>
