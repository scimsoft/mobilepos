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
                        @if(!session('table_number'))
                        Numero de Pedido:<b> {{Session::get('order_id')}}</b>
                    @else
                        <br>
                        Numero de Mesa:<b> {{Session::get('table_number')}}</b>
                    @endif

                </div>
            </div>


        </div>
        <div class="card">
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Nombre</td>
                    <td>Precio</td>

                    <td></td>
                </tr>
                </thead>
                <tbody>
                @foreach($orderlines as $orderline)
                    <tr>
                        <td>{{$orderline->product->name}}</td>

                        <td>@money($orderline->price*1.1)</td>

                        @if($orderline->printed == 1)
                            <td><img src="/img/selected.png" width="32px"> </td>
                        @else
                            <td ><a href="{{ route('orderline.destroy',$orderline->id)}}" class="btn  btn-danger btn-delete"> <b>X</b></a></td>
                         @endif
                    </tr>

                @endforeach
                <tr>
                    <td><b>Total:</b></td>

                    <td><b>@money(Session::get('order_total')*1.1)</b> </td>

                    <td ></td>

                </tr>
                <tr>
                    <td colspan="1">
                        <a href="/order" class="btn btn-primary">Añadir</a>
                    </td>
                    @if(session('table_number')AND($pendientesDePedir==1)){
                    <td colspan="1">
                        <a href="/pedir/{{Session::get('order_id')}}" class="btn btn-primary">Confirmar</a>
                    </td>
                }@elseif(session('table_number')AND($pendientesDePedir==0)){
                    <td colspan="1">
                        <a href="/checkout" class="btn btn-primary">Pagar online</a>
                    </td>
                    <td colspan="1">
                        <a href="/pedircuenta/{{session('order_id')}}" class="btn btn-primary">Pedir la Cuenta</a>
                    </td>
                        }@else{
                    <td colspan="1">
                        <a href="/checkout" class="btn btn-primary">Pagar online</a>
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