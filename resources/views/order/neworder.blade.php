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

                        <a id="drinks-button" href="/products/category/DRINKS" type="button" class="btn btn-labeled btn-primary mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-beer"></i></span>&nbsp; Bebidas</a>

                        <a id="food-button" href="/products/category/FOOD" type="button" class="btn btn-labeled btn-primary mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-cutlery"></i></span>&nbsp; Comidas</a>

                        <a id="coffee-button" href="/products/category/COFFEE" type="button" class="btn btn-labeled btn-primary mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-coffee"></i></span>&nbsp; Cafes</a>

                        <a id="coffee-button" href="/products/category/COCTELES" type="button" class="btn btn-labeled btn-primary mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-glass"></i></span>&nbsp; Cocteles</a>

                        <a id="coffee-button" href="/products/category/COPAS" type="button" class="btn btn-labeled btn-primary mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-bolt"></i></span>&nbsp; Copas</a>

                        <a id="coffee-button" href="/products/category/VINOS" type="button" class="btn btn-labeled btn-primary mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-flask"></i></span>&nbsp; Vinos</a>

                        <a id="coffee-button" href="/products/category/OTROS" type="button" class="btn btn-labeled btn-primary mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>&nbsp; Otros</a>

                </div>
                <table id="products-table" class="table table-striped middleTable">
                    <thead>
                    <tr>
                        <td></td>
                        <td>Nombre</td>

                        <td>Precio</td>
                        <td>&nbsp;</td>


                    </tr>
                    </thead>
                    <tbody>
                                       
                    @foreach($controllerproducts as $product)
                        @if($product->product_cat)
                        <tr class="productrow">
                            <td >
                                @if (empty($product->image))
                                    <div>&nbsp;</div>
                                @else
                                    <img src="data:image/png;base64,{{$product->image}}" class="img-fluid" id="product_image"> </td>
                            @endif
                            <td class=""><b>{{$product->name}}</b></td>
                            <td class="nowrapcol"><b>@money($product->pricesell *1.1)</b></td>
                            <td>


                                <button  class="btn btn-primary add-to-cart btn-add" onclick="addProduct('{{$product->id}}')" type="submit">+</button>

                            </td>

                        </tr>
                    @endif
                       {{-- <tr>
                            <td COLSPAN="3">{{$product->DESCRIPTION}</td>






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
    <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'></script>
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
        function addProduct(productID){
            jQuery.ajax({
                url: '/orderline/add/' + productID,
                type: "GET",
                dataType: "json",
                success: function (data) {

                    setOrderTotal();
                }
            });
        }
        $('.add-to-cart').on('click', function () {
            var cart = $('.fa-shopping-cart');
            var imgtodrag =  $(this).closest('.productrow').find('.img-fluid');
            if (imgtodrag) {
                var imgclone = imgtodrag.clone()
                    .offset({
                        top: imgtodrag.offset().top,
                        left: imgtodrag.offset().left
                    })
                    .css({
                        'opacity': '0.5',
                        'position': 'absolute',
                        'height': '150px',
                        'width': '150px',
                        'z-index': '100'
                    })
                    .appendTo($('body'))
                    .animate({
                        'top': cart.offset().top + 10,
                        'left': cart.offset().left + 10,
                        'width': 75,
                        'height': 75
                    }, 1000);



                imgclone.animate({
                    'width': 0,
                    'height': 0
                }, function () {
                    $(this).detach()
                });
            }
        });

    </script>



@stop