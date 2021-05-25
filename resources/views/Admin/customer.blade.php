@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if($form === 1)
                    <p>Es del form 1</p>
                @elseif($form === 2)
                    <p>Es del form 2</p>
                @endif
            </div>
        </div>
    </div>
@endsection
