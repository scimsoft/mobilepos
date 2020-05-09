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
                        <td>{{round($orderline->price*1.1,2)}} €</td>
                        <td>{{$orderline->comment}} </td>
                        <td colspan=2><a href="{{ route('orderline.destroy',$orderline->id)}}"><img src="/img/delete16.png"></a></td>

                    </tr>

                @endforeach
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
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script>
        jQuery(document).ready(function () {
            $('#deleteOrderLine a').click(function(e){
                alert('clicked');

            });
        });

    </script>



@stop