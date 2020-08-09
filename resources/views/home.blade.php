@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div>&nbsp;</div>


                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="col-centered" > <h4 ><center>Adelante la cola, pide online.</center></h4></div>
                        <br>

                        <div class="col-6 col-centered">
                        <div>&nbsp;</div>

                        <a href="" class="btn  btn-block btn-primary btn-start" data-toggle="modal" data-target="#yourModal">START</a>
                        <div>&nbsp;</div>
                            <div>&nbsp;</div>
                            {{--@if(count($places)>1)--}}
                                {{--<a href="/order" class="btn btn-primary btn-block">Pedir para llevar</a>--}}
                                {{--<div>&nbsp;</div>--}}
                            {{--@endif--}}
                        </div>
                        <div>&nbsp;</div>
                        <a href="/menu" class="btn  btn-block btn-primary btn-start" >Solo ver la Comida</a>
                        <div>&nbsp;</div>
                        <div class=" col-centered">
                            <h4 class="text-center">INSTRUCCIONES</h4>
                        </div>
                        <div>




                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">1.  Elige tu numero de mesa</li>
                                <li class="list-group-item">2.  Selecciona la bebida y comida</li>
                                <li class="list-group-item">3.  Pulsa el boton de confirmar</li>
                                <li class="list-group-item">4.  Puedes pagar online o a la camarera</li>
                                <li class="list-group-item"></li>
                            </ul>

                        </div>

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
            <div ><center>Solo se sirve cafe hasta la 5 de la tarde</center></div>
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