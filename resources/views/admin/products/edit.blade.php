@extends('layouts.admin')

@section('content')
    <div   id="app">
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
                    <form action="{{ route('products.update', $product->id) }}" method="post">
                        @method('PATCH')
                        @csrf

                        <div class="form-row">
                            <label for="name" class="col-sm-2 col-form-label">Nombre</label>
                            <input name="name" class="form-control col-md-6" type="text" value="{{$product->name}}">
                        </div>
                        <div>&nbsp;</div>
                        <div class="form-row">
                            <img  name="image" src="data:image/png;base64,{{$product->image}}">




                        </div>
                        <div class="form-row">
                            <a href="/crop-image/{{$product->id}}"  class="btn btn-primary" >
                                Editar imagen
                            </a>
                        </div>

                        <div>&nbsp;</div>
                        <div class="form-row">
                            <label for="pricebuy" class="col-sm-2 col-form-label">Compra </label>
                            <input name="pricebuy" class="form-control col-md-1" type="text"
                                   value="{{$product->pricebuy}}">

                            <div class="col-md-2"></div>
                            <label for="pricesell" class="col-sm-2 col-form-label">Venta</label>
                            <input name="pricesell" class="form-control col-md-1" type="text"
                                   value="{{round($product->pricesell *1.1,2)}}">
                            <label class="col-sm-2 col-form-label" for="isVisible">Disponible</label>
                            <input type="checkbox" class="form-control col-md-1" id="isVisible" name="isVisible"
                            @if($product->product_cat)
                            checked="checked"
                                   @endif
                            >
                        </div>
                        <div>&nbsp;</div>
                        <div class="form-row">
                            <label for="description" class="col-sm-2 col-form-label">Dicripcion</label>
                            <textarea name="description" class="form-control col-md-8" rows="3"  >{{$product->description}}</textarea>
                        </div>
                        <div class="form-row">

                        </div>

                        <div>

                        </div>
                        <div>
                            <div class="" id="ProductPrice">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Imagen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>


    </script>



@stop