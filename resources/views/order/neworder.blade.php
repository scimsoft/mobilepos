@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="card">
                <div class="card-header">Order</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <a id="drinks-button" href="/products/category/DRINKS" type="button" class="btn btn-labeled btn-success">
                            <span class="btn-label"><i class="fa fa-glass"></i></span>&nbsp; Bebidas</a>

                        <a id="food-button" href="/products/category/FOOD" type="button" class="btn btn-labeled btn-success">
                            <span class="btn-label"><i class="fa fa-cutlery"></i></span>&nbsp; Comidas</a>

                        <a id="coffee-button" href="/products/category/COFFEE" type="button" class="btn btn-labeled btn-success">
                            <span class="btn-label"><i class="fa fa-coffee"></i></span>&nbsp; Cafes</a>

                </div>
                <table id="products-table" class="table table-bordered">
                    <thead>
                    <tr>
                        <td></td>
                        <td>Name</td>

                        <td>venta</td>
                        <td>venta</td>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($controllerproducts as $product)
                        <tr>
                            <td rowspan="2">
                                @if (empty($product->IMAGE))
                                    <div>no</div>
                                @else
                                    <img src="data:image/png;base64,{{$product->IMAGE}}" class="img-fluid"> </td>
                            @endif
                            <td ><b>{{$product->NAME}}</b></td>
                            <td><b>{{round($product->PRICESELL *1.1,2)}} €</b></td>
                            <td>


                                <a href="{{ route('order.addproduct', [$product->ID])}}" class="btn btn-primary" type="submit">Añadir</a>

                            </td>
                        </tr>
                        <tr>
                            <td COLSPAN="3">{{$product->DESCRIPTION}}</td>






                        </tr>
                    @endforeach

                    </tbody>
                </table>



            </div>


        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#drinks-button").click(function(){
                alert("drinks");
                loadProducts('DRINKS');
            });

        $(document).ready(function() {
            $("#food-button").click(function(){
                alert("food");
                loadProducts('FOOD');
            });
        });
        $(document).ready(function() {
            $("#coffee-button").click(function(){
                alert("COFFEE");
            });
        });

        function loadProducts(category){
            jQuery.ajax({
                url: '/products/ajax/' + category,
                type: "GET",
                dataType: "json",
                success: function (data) {
                newRowContent="";


                    $("#products-table tbody").append(newRowContent);
                }
            });


        }








        });

    </script>



@stop