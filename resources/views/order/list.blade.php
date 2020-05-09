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

                        <select name="category" >
                            @foreach($categories as $name => $id)
                                <option value="{{$id}}">{{$name}}</option>
                            @endforeach
                        </select>

                            <select name="products" >
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
            <div id="ProductName" class="card-header">Product</div>

            <div class="card-body">
                <div class="row">
                <div class="col-sm">
                    <img id="ProductImage">
                </div>
                    <div class="col-sm">
                        <div id="DescripcionText"></div>
                    </div>
                </div>
                <div class="m-md-3">
                    <div class="" id="ProductPrice">
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-sm"></div>
                <div class="col-sm"><button id="addButton" class="btn btn-primary" >Añadir</button> </div>
            </div>
            @if (Auth::check())
                    <a href="" id="ProductEditLink">edit</a>
            @endif
    </div>
@endsection
@section('scripts')

    <script>
        jQuery(document).ready(function ()
        {
            var products = {!!$products!!}
            var productID;
            var sellprice;
            var order_id;
            @if(session()->has('order_id'))
                order_id= {{Session::get('order_id')}};
           @else
               order_id=0;
            @endif
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            jQuery('select[name="category"]').on('change',function(){
                var categoryID = jQuery(this).val();
                if(categoryID) {
                    console.log(products);
                    jQuery('select[name="products"]').empty();
                    $('select[name="products"]').append('<option value="0">'+"Elegir"+'</option>');
                    jQuery.each(products, function ( value,key) {
                        if(key['CATEGORY'] == categoryID)
                        $('select[name="products"]').append('<option value="' + key['ID'] + '">' + key['NAME'] + '</option>');
                    });
                }
                else
                {
                    $('select[name="products"]').empty();
                }
            });
            jQuery('select[name="products"]').on('change',function(){
                productID = jQuery(this).val();

                if(productID)
                {
                    jQuery.ajax({
                        url : '/products/ajax/' +productID,
                        type : "GET",
                        dataType : "json",
                        success:function(data)
                        {

                            console.log(data);

                            $('#ProductName').html(data['DISPLAY'].replace(/<[^>]*>?/gm, ''));

                            sellprice = data['PRICESELL'];
                            $('#ProductPrice').html((data['PRICESELL']*1.1).toFixed(2)+'€');

                            $('#DescripcionText').html(data['DESCRIPTION']);


                            document.getElementById('ProductImage').setAttribute('src','data:image/png;base64,'+data['IMAGE']);
                            document.getElementById('ProductEditLink').setAttribute('href','/products/'+data['ID']+'/edit');
//TODO


                        }
                    });
                }
            });

            $("#addButton").click( function()
                {


                    var orderline = JSON.stringify([order_id, productID,sellprice]);
                    jQuery.ajax({
                        url : '/orderlineadd/ajax/',
                        type : "POST",
                        data: {orderline:orderline},
                        success:function(data)
                        {
                            order_id = data['mobile_order_id'];


                            setOrderTotal(order_id);
                        },
                        error: function (request, status, error) {
                            alert('error:'+status);
                        }
                    });
                }
            );
            function setOrderTotal(order_id){

                jQuery.ajax({
                    url: '/total/ajax/' + order_id,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {

                        $('#ordertotal').html(" "+(data*1.1).toFixed(2) + "€");
                        document.getElementById('basketLink').setAttribute('href','/basket/'+order_id);

                    }
                });
            }
        });



   </script>



@stop