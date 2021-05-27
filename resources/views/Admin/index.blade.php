@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-white bg-dark">Buscar Socio</div>
                    <div class="col-md-12" style="padding-top: 15px;">
                        <label><b>Busca al socio por número de cliente o por su correo electrónico</b></label>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12" style="display: flex; justify-content: center;">
                                <form method="GET" action="{{route('admin.search.client.number')}}">
                                    @csrf
                                    <label for="client_number" class="col-md-8 col-form-label text-md-right">No. de cliente</label>

                                    <div class="col-md-12">
                                        <input id="client_number" type="number" class="form-control client_numberInput @error('client_number') is-invalid @enderror" name="client_number" value="{{ old('client_number') }}" maxlength="8" required autocomplete="client_number" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12" style="display: flex; justify-content: center; padding-top: 15px;">
                                        <input type="submit" class="btn" value="Buscar" style="background-color: #00a5e6; color: #FFFFFF; width: 100px;">
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-md-12" style="display: flex; justify-content: center;">
                                <form method="GET" action="{{route('admin.search.email')}}">
                                    @csrf
                                    <label for="email" class="col-md-8 col-form-label text-md-right">Email</label>
                                    <div class="col-md-12">
                                        <input id="name" type="email" class="form-control emailInput @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" >

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12" style="display: flex; justify-content: center; padding-top: 15px;">
                                        <input type="submit" class="btn" value="Buscar" style="background-color: #00a5e6; color: #FFFFFF; width: 100px;">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    $(document).ready(function(){
        $("#client_number").mask('00000000');
    });

</script>
