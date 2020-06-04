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


                </div>
            </div>


        </div>
        <div class="card">
            <div id="ProductName" class="card-header">Product</div>

            <div class="card-body">
                <div class="form-group">
                    <form action="{{ route('products.store') }}" method="post">
                        @csrf
                    <div class="form-row">
                        <label for="name" class="col-sm-2 col-form-label">Nombre</label>
                        <input name="name" class="form-control col-md-6" type="text" >
                    </div>
                    <div>&nbsp;</div>
                    <div class="form-row">
                        <img id="ProductImage" >
                    </div>
                    <div>&nbsp;</div>
                    <div class="form-row">
                        <label for="pricebuy" class="col-sm-2 col-form-label">Compra </label>
                        <input name="pricebuy" class="form-control col-md-1" type="text" >

                        <div class="col-md-2"></div>
                        <label for="pricesell" class="col-sm-2 col-form-label">Venta</label>
                        <input name="pricesell" class="form-control col-md-1" type="text"
                               >
                    </div>
                    <div>&nbsp;</div>
                    <div class="form-row">
                        <label for="description" class="col-sm-2 col-form-label">Dicripcion</label>
                        <textarea  name="description" class="form-control col-md-8"  rows="3"></textarea>
                    </div>

                    <div>

                    </div>
                    <div>
                        <div class="" id="ProductPrice">
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">SAVE</button>
    </form>
        </div>
        @endsection
        @section('scripts')
            <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
            <script>
                jQuery(document).ready(function () {
                });

            </script>



@stop