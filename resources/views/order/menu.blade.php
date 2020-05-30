@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="card">
                <div class="card-header">Order</div>

                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                </div>
                <table id="products-table" class="table table-bordered">
                    <thead>
                    <tr>
                        <td></td>
                        <td>Nombre</td>

                        <td>Precio</td>


                    </tr>
                    </thead>
                    <tbody>
                    @foreach($controllerproducts as $product)
                        @if($product->product_cat)
                        <tr>
                            <td  height="64px">
                                @if (empty($product->IMAGE))
                                    <div>&nbsp;</div>
                                @else
                                    <img src="data:image/png;base64,{{$product->IMAGE}}" class="img-fluid" > </td>
                            @endif
                            <td ><b>{{$product->NAME}}</b></td>
                            <td><b>{{round($product->PRICESELL *1.1,2)}} €</b></td>

                        </tr>
                        @endif
                       {{-- <tr>
                            <td COLSPAN="3">{{$product->DESCRIPTION}}</td>






                        </tr>--}}
                    @endforeach

                    </tbody>
                </table>

                {{ $controllerproducts->links() }}

            </div>


        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#drinks-button").click(function(){

                loadProducts('DRINKS');
            });

        $(document).ready(function() {
            $("#food-button").click(function(){

                loadProducts('FOOD');
            });
        });
        $(document).ready(function() {
            $("#coffee-button").click(function(){

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