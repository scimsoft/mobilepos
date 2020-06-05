@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div>&nbsp;</div>
                <div class="card-header col-centered"><h1 class="display-4"> Pide Online</h1></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="col-centered" > <h4 ><center>Adelante la cola, pide online.</center></h4></div>
                        <br>

                        <div>&nbsp;</div>
                        @if(count($places)>1)
                    <a href="/order" class="btn btn-success btn-block">Para llevar</a>
                        <div>&nbsp;</div>
                        @endif
                        <a href="" class="btn btn-success btn-block" data-toggle="modal" data-target="#yourModal">Para la mesa</a>
                        <div>&nbsp;</div>

                        {{--<div>&nbsp;</div>--}}
                        {{--<a href="/menu" class="btn btn-success btn-block" >La carta de hoy</a>--}}
                        {{--<div>&nbsp;</div>--}}


                        <div class="modal fade" id="yourModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Introdusco tu numero de mesa</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                                    </div>
                                    <div class="modal-body">
                                        <select   id="placesselect" class="form-control">
                                        @foreach($places as $place)
                                                <option value="{{$place->id}}">{{$place->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button id="orderbutton" type="button" class="btn btn-primary">Pedir</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <img src="/img/terraza.jpg" class="img-fluid rounded mx-auto d-block">


                </div>
            </div>
            <div ><a href="/admin" class="btn btn-primary">ADMIN</a></div>
        </div>
    </div>

</div>

@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        jQuery(document).ready(function () {

            $("#orderbutton").click(function () {

                //alert('/order_mesa/'+ $("#placesselect").find(":selected").text());
                window.location.href = ('/order/'+ $("#placesselect").val());

            });
        }
        )

    </script>



@stop