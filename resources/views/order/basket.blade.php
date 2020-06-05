@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="card">
                <div class="card-header">Tu Pedido</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Numero de Pedido:<b> {{Session::get('order_id')}}</b>
                        <br>
                        Numero de Mesa:<b> {{Session::get('table_number')}}</b>


                </div>
            </div>


        </div>
        <div class="card">
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Nombre</td>
                    <td>Precio</td>
                    <td>Borrar</td>
                    <td>Status</td>
                </tr>
                </thead>
                <tbody>
                @foreach($orderlines as $orderline)
                    <tr>
                        <td>{{$orderline->productname}}</td>

                        <td>@money($orderline->price*1.1)</td>

                        <td ><a href="{{ route('orderline.destroy',$orderline->id)}}" class="btn  btn-danger"> <b>X</b></a></td>
                        <td>@if($orderline->printed == false)<img src="/img/selected.png" width="32px">@endif </td>
                    </tr>

                @endforeach
                <tr>
                    <td><b>Total:</b></td>

                    <td><b>@money(Session::get('order_total'))</b> </td>

                    <td ></td>
                    <td> </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <a href="/order" class="btn btn-primary">Pedir más</a>
                    </td>
                    @if(session('table_number')){
                    <td colspan="1">
                        <a href="/pedir/{{Session::get('order_id')}}" class="btn btn-primary">Pedir</a>
                    </td>
                }@else{
                    <td colspan="1">
                        <a href="/checkout" class="btn btn-primary">Pagar</a>
                    </td>
                        }
                        @endif
                </tr>

                </tbody>
            </table>
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