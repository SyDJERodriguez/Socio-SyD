@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-white bg-dark">Buscar Sucursal</div>
                    <div class="col-md-12" style="padding-top: 15px;">
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12" style="display: flex; justify-content: center;">
                                <form method="GET" action="{{route('admin.search.branch')}}">
                                    @csrf
                                    <div class="col-md-12">
                                        <select class="form-control" name="email" required>
                                            <option value="">Seleccione la sucursal</option>
                                            @if(isset($branches))
                                            @foreach ($branches as $branch)
                                                 <option value="{{$branch->branch}}">{{$branch->branch_name}}</option>                                     
                                            @endforeach
                                        @endif
                                        </select>
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
