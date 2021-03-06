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
                    {{--{{dd($products)}}--}}

                    <select name="category" class="form-control">
                        <option value="0">Elegir Categoria </option>
                        @foreach($categories as $name => $id)
                            <option value="{{$id}}">{{$name}}</option>
                        @endforeach
                    </select>
                        <div>&nbsp;</div>
                    <select name="products" class="form-control">
                        <option value="0">Elegir Producto </option>
                        @foreach($products as $product)
                            <option value="{{$product['ID']}}">{{$product['NAME']}}</option>
                        @endforeach
                    </select>

                    {{--<category-products-component--}}
                    {{--:products='{{ json_encode($products)}}'--}}
                    {{--:categories='{{ json_encode($categories)}}'>--}}
                    {{----}}
                    {{--</category-products-component>--}}


                </div>
            </div>


        </div>
        <div class="card">
            <div id="ProductName" class="card-header">Producto</div>

            <div class="card-body">
                <div class="row">
                    <div class="col-sm">
                        <img id="ProductImage">
                    </div>
                    <div class="col-sm">
                        <div id="DescripcionText"> 1. Elige los productos en arriba y añadolos a la cesta. <br> <br>  2. Cuando haz elegido todos los productos pulsa la cesta para pagar.<br> <br></div>
                    </div>
                </div>
                <div class="m-md-3">
                    <div class="" id="ProductPrice">
                    </div>
                </div>

                <div class="container">
                    <div class="row">

                        <div class="col-sm">
                            <div class="alert alert-success" id="upload-success"
                                 style="display: none;margin-top:10px;"></div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div id="addButton" class="btn-block btn btn-primary">Añadir</div>
                        </div>
                    </div>
                </div>
                @if (Auth::user())
                    @if(Auth::user()->isAdmin())
                        <a href="" id="ProductEditLink">edit</a>
                    @endif
                @endif
            </div>
        </div>
        @endsection
        @section('scripts')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script>
                jQuery(document).ready(function () {
                    var products = {!!$products!!}
                    var productID;
                    var sellprice;
                    var order_id={{Session::get('order_id')}};
                    var units = 1;


                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                    jQuery('select[name="category"]').on('change', function () {
                        var categoryID = jQuery(this).val();
                        if (categoryID) {
                            console.log(products);
                            jQuery('select[name="products"]').empty();
                            $('select[name="products"]').append('<option value="0">' + "Elegir" + '</option>');
                            jQuery.each(products, function (value, key) {
                                if (key['CATEGORY'] == categoryID)
                                    $('select[name="products"]').append('<option value="' + key['ID'] + '">' + key['NAME'] + '</option>');
                            });
                             }else {
                                $('select[name="products"]').empty();
                             }
                    });
                    jQuery('select[name="products"]').on('change', function () {
                        productID = jQuery(this).val();

                        if (productID) {
                            jQuery.ajax({
                                url: '/products/ajax/' + productID,
                                type: "GET",
                                dataType: "json",
                                success: function (data) {

                                    console.log(data);
                                    units = 1;

                                    $('#ProductName').html(data['display'].replace(/<[^>]*>?/gm, ''));

                                    sellprice = data['pricesell'];
                                    $('#ProductPrice').html((data['pricesell'] * 1.1).toFixed(2) + '€');

                                    $('#DescripcionText').html(data['description']);

                                    $("#upload-success").hide();
                                    document.getElementById('ProductImage').setAttribute('src', 'data:image/png;base64,' + data['image']);
                                    @if (Auth::user())
                                        @if(Auth::user()->isAdmin())
                                            document.getElementById('ProductEditLink').setAttribute('href', '/products/' + data['id'] + '/edit');
                                        @endif
                                    @endif


                                }
                            });
                        }
                    });

                    $("#addButton").click(function () {


                            var orderline = JSON.stringify([order_id, productID, sellprice]);
                            jQuery.ajax({
                                url: '/orderlineadd/ajax',
                                type: "POST",
                                data: {orderline: orderline},
                                success: function (data) {

                                    $("#upload-success").html("Añadido " + units + " al pedido");

                                    $("#upload-success").show();
                                    units = units + 1;
                                    setOrderTotal(order_id);

                                },
                                error: function (request, status, error) {
                                    alert('error:' + status);
                                }
                            });
                        }
                    );
                    function setOrderTotal(order_id) {

                        jQuery.ajax({
                            url: '/total/ajax/' + order_id,
                            type: "GET",
                            dataType: "json",
                            success: function (data) {

                                $('#ordertotal').html(" " + (data * 1.1).toFixed(2) + "€");
                                document.getElementById('basketLink').setAttribute('href', '/basket/' + order_id);

                            }
                        });
                    }
                });


            </script>



@stop