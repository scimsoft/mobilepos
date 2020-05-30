@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="card">
                <div class="card-header">Tu Pedido</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        @if ($message = Session::get('success'))
                            <div class="w3-panel w3-green w3-display-container">
                                <span onclick="this.parentElement.style.display='none'" class="w3-button w3-green w3-large w3-display-topright">&times;</span>
                                <p>{!! $message !!}</p>
                            </div>
                            <?php Session::forget('success');?>
                        @endif
                        @if ($message = Session::get('error'))
                            <div class="w3-panel w3-red w3-display-container">
                                <span onclick="this.parentElement.style.display='none'" class="w3-button w3-red w3-large w3-display-topright">&times;</span>
                                <p>{!! $message !!}</p>
                            </div>
                            <?php Session::forget('error');?>
                        @endif

                    <center>Numero de Pedido:<b> {{$order_id}}</b></center>
                    <br>
                    <br>
                        <center><b> La camarera esta avisada</b></center>



                        </div>

                    </h3>
                </div>

            </div>
        </div>


    </div>

        @endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    @stop
