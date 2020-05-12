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


                </div>
            </div>


        </div>
        <div class="card">
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>units</td>
                    <td>precio</td>
                    <td>nota</td>

                    <td colspan=2>Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($orderlines as $orderline)
                    <tr>
                        <td>{{$orderline->productname}}</td>
                        <td>{{$orderline->unit}}</td>
                        <td>{{number_format($orderline->price*1.1,2)}} €</td>
                        <td>{{$orderline->comment}} </td>
                        <td colspan=2><a href="{{ route('orderline.destroy',$orderline->id)}}"><button type="button" class="btn btn-labeled btn-danger">
                                    <span class="btn-label"><i class="fa fa-trash"></i></span></button></a></td>

                    </tr>

                @endforeach
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td id="orderTotal">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan=2>&nbsp;</td>

                </tr>
                <tr>
                    <td colspan="3">
                        <a href="/order" class="btn btn-primary">Seguir Comprando</a>
                    </td>
                    <td colspan="2">
                        <a href="/checkout" class="btn btn-primary">Pagar</a>
                    </td>
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