@extends('layouts.app')

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
                    <form action="{{ route('products.update', $product->ID) }}" method="post">
                        @method('PATCH')
                        @csrf

                        <div class="form-row">
                            <label for="NAME" class="col-sm-2 col-form-label">Nombre</label>
                            <input name="NAME" class="form-control col-md-6" type="text" value="{{$product->NAME}}">
                        </div>
                        <div>&nbsp;</div>
                        <div class="form-row">
                            <img  name="IMAGE" src="data:image/png;base64,{{$product->IMAGE}}">




                        </div>
                        <div class="form-row">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Editar imagen
                            </button>
                        </div>

                        <div>&nbsp;</div>
                        <div class="form-row">
                            <label for="PRICEBUY" class="col-sm-2 col-form-label">Compra </label>
                            <input name="PRICEBUY" class="form-control col-md-1" type="text"
                                   value="{{$product->PRICEBUY}}">

                            <div class="col-md-2"></div>
                            <label for="PRICESELL" class="col-sm-2 col-form-label">Venta</label>
                            <input name="PRICESELL" class="form-control col-md-1" type="text"
                                   value="{{round($product->PRICESELL *1.1,2)}}">
                        </div>
                        <div>&nbsp;</div>
                        <div class="form-row">
                            <label for="DESCRIPTION" class="col-sm-2 col-form-label">Dicripcion</label>
                            <textarea name="DESCRIPTION" class="form-control col-md-8" rows="3"  >{{$product->DESCRIPTION}}</textarea>
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
                    <div>
                        <img id="image" style="max-width: 100%;"  src="data:image/png;base64,{{$product->IMAGE}}">
                    </div>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha256-WqU1JavFxSAMcLP2WIOI+GB2zWmShMI82mTpLDcqFUg=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>

    <script>
        jQuery(document).ready(function () {
        });

        var $image = $('#image');

        $image.cropper({
            aspectRatio: 16 / 9,
            crop: function(event) {
                console.log(event.detail.x);
                console.log(event.detail.y);
                console.log(event.detail.width);
                console.log(event.detail.height);
                console.log(event.detail.rotate);
                console.log(event.detail.scaleX);
                console.log(event.detail.scaleY);
            }
        });

        // Get the Cropper.js instance after initialized
        var cropper = $image.data('cropper');

    </script>



@stop