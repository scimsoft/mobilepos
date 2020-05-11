@extends('layouts.app')

@section('content')

    <div class="panel panel-info">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <div id="upload-demo"></div>
                </div>
                <div class="col-md-4" style="padding:5%;">
                    <strong>Choose image to crop:</strong>
                    <input type="file" id="image_file">
                    <button class="btn btn-primary btn-block upload-image" style="margin-top:2%">Upload Image</button>
                    <div class="alert alert-success" id="upload-success" style="display: none;margin-top:10px;"></div>

                </div>
                <div class="col-md-4">
                    <div id="preview-crop-image" style="background:#9d9d9d;width:300px;padding:50px 50px;height:300px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
    <script>
        jQuery(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

            var resize = $('#upload-demo').croppie({
                enableExif: true,
                enableOrientation: true,
                viewport: { // Default { width: 100, height: 100, type: 'square' }
                    width: 200,
                    height: 200,
                    type: 'circle' //square
                },
                boundary: {
                    width: 300,
                    height: 300
                }
            });
            $('#image_file').on('change', function () {
                var reader = new FileReader();
                reader.onload = function (e) {
                    resize.croppie('bind', {
                        url: e.target.result
                    }).then(function () {
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(this.files[0]);
            });
            $('.upload-image').on('click', function (ev) {
                alert('click');
                resize.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function (img) {
                    html = '<img src="' + img + '" />';
                    $("#preview-crop-image").html(html);

                    $.ajax({
                        url: "/crop-image",
                        type: "POST",
                        data: {"image": img,"productID":"{{$product->ID}}"},
                        success: function (data) {
                            $("#upload-success").html("Images cropped and uploaded successfully.");
                            $("#upload-success").show();
                            window.location.href = "/products/{{$product->ID}}/edit";

                        }
                    });
                });
            });
        resize.croppie('bind', {
        url: 'data:image/png;base64,{{$product->IMAGE}}',});
    </script>
@stop