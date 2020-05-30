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
                    {{--{{dd($products)}}--}}
                        <a id="drinks-button" href="/products/admincategory/DRINKS" type="button" class="btn btn-labeled btn-success mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-beer"></i></span>&nbsp; Bebidas</a>

                        <a id="food-button" href="/products/admincategory/FOOD" type="button" class="btn btn-labeled btn-success mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-cutlery"></i></span>&nbsp; Comidas</a>

                        <a id="coffee-button" href="/products/admincategory/COFFEE" type="button" class="btn btn-labeled btn-success mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-coffee"></i></span>&nbsp; Cafes</a>

                        <a id="coffee-button" href="/products/admincategory/COCTELES" type="button" class="btn btn-labeled btn-success mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-glass"></i></span>&nbsp; Cocteles</a>

                        <a id="coffee-button" href="/products/admincategory/COPAS" type="button" class="btn btn-labeled btn-success mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-bolt"></i></span>&nbsp; Copas</a>

                        <a id="coffee-button" href="/products/admincategory/VINOS" type="button" class="btn btn-labeled btn-success mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-flask"></i></span>&nbsp; Vinos</a>

                        <a id="coffee-button" href="/products/admincategory/OTROS" type="button" class="btn btn-labeled btn-success mr-1 mb-1">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>&nbsp; Otros</a>



                </div>
            </div>


        </div>
        <div class="card">
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Disponible</td>
                    <td>Compra</td>
                    <td>Venta</td>

                    <td colspan = 2>Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr id="{{$product->ID}}">
                        <td>
                            @if (empty($product->IMAGE))
                                <div>no</div>
                            @else
                                <img src="data:image/png;base64,{{$product->IMAGE}}" width="32"> </td>
                            @endif
                        <td>{{$product->NAME}}</td>

                        <td><input type="checkbox" class="form-check" name=="catalogcheckbox" @if($product->product_cat) checked="checked" @endif>


                        </td>

                        <td>@money($product->PRICEBUY)</td>
                        <td>@money($product->PRICESELL *1.1)</td>

                        <td>
                            <a href="{{ route('products.edit',$product->ID)}}" class="btn btn-primary">Edit</a>
                        </td>
                        {{--<td>
                            <form action="{{ route('products.destroy', $product->ID)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>--}}
                    </tr>
                @endforeach

                </tbody>
            </table>
            {{ $products->links() }}
        </div>

    </div>
@endsection
@section('scripts')
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script>
        jQuery(document).ready(function () {

            $("input:checkbox").change(function() {
                var product_id = $(this).closest('tr').attr('id');

                $.ajax({
                    type:'POST',
                    url:'/product/catalog',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    data: { "product_id" : product_id },
                    success: function(data){

                    }
                });
            });
        });

    </script>



@stop