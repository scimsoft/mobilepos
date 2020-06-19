@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header col-centered"><h1 class="display-3"> Pide Online</h1></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="col-centered" > <h4 >Adelante la cola, pide online y te llega aviso al movil para recoger su pedido.</h4></div>
                        <br>

                        <div>&nbsp;</div>
                      <a href="/products" class="btn btn-primary"> Products</a>
                        <a href="/orderlist" class="btn btn-primary"> Orders</a>
                        <a href="/cleanhome" class="btn btn-primary"> Mesas</a>

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