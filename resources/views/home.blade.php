@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h1 class="display-3"> Pide Online</h1></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="float-md-none"> Adelante la cola, pide online y te llega aviso al movil para recoger su pedido.</div>
                        <br>
                    <img src="/img/pescaito-frito-t.jpg" class="img-fluid">
                        <div>&nbsp;</div>
                    <a href="/order" class="btn btn-success btn-block">Hacer el Pedido</a>
                        <div>&nbsp;</div>

                            <img src="/img/cruzcampo.jpg" class="img-fluid rounded mx-auto d-block">


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        jQuery(document).ready(function () {


        });

    </script>



@stop