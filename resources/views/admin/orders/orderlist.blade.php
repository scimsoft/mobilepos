@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="card">

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
                    <td>Order_ID</td>
                    <td>Table</td>
                    <td>Status</td>
                    <td>Time</td>

                    <td colspan="3"  >Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($open_orders as $order)
                    <tr>
                        <td><a href="/basket/{{$order->id}}">{{$order->id}}</a></td>
                        <td>{{$order->table_number}}</td>
                        <td>{{$order->status}}</td>

                        <td>{{ (new Carbon(now()))->diff(new Carbon($order->updated_at))->format('%h:%I') }}</td>


                        <td ><a href="/orderlist/setpaid/{{$order->id}}" class="btn btn-success">pay</a> </td>
                        <td ><a href="/orderlist/print/{{$order->id}}" class="btn btn-outline-success">print</a> </td>
                        <td ><a href="/orderlist/setready/{{$order->id}}" class="btn btn-primary">ready</a> </td>
                        <td ><a href="/orderlist/setfinish/{{$order->id}}" class="btn btn-warning">finish</a> </td>
                    </tr>

                @endforeach

                </tbody>
            </table>
            {{ $open_orders->links() }}
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