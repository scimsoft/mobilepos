@extends('layouts.app')

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


                </div>
            </div>


        </div>
        <div class="card">
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>compra</td>
                    <td>venta</td>

                    <td colspan = 2>Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>
                            @if (empty($product->IMAGE))
                                <div>no</div>
                            @else
                                <img src="/img/shopping-bag-peq.png" width="32"> </td>
                            @endif
                        <td>{{$product->NAME}}</td>
                        <td>{{$product->PRICEBUY}} €</td>
                        <td>{{round($product->PRICESELL *1.1,2)}} €</td>

                        <td>
                            <a href="{{ route('products.edit',$product->ID)}}" class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('products.destroy', $product->ID)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
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
        });

    </script>



@stop