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

                    <center>Numero de Pedido:<b> {{Session::get('order_id')}}</b></center>
                    <br>
                    <br>
                    <div class="col-centered">INSTRUCCIONES:</div>
                    <div>1. Paga online con tu tarjeta de debito o credito y te llega un aviso a tu movil cuando tu
                        pedido esta lista.
                    </div>
                        <br>
                    <div>2. Con tu numero de pedido te acercas a la barra y paga en el TPV (solo tarjetas, moviles
                        etc..)
                    </div>
                    <br>
                    <h3>
                        <div class="row">
                            <div class="col-6 col-centered">
                                Su Pedido:
                            </div>
                    </h3>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <td ><b>Tipo</b></td>
                                <td><b>Precio</b></td>

                            </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>Base: </td>

                                    <td> {{round(Session::get('order_total'),2)}} €</td>

                                </tr>
                                <tr>
                                    <td>IVA </td>

                                    <td> {{round(Session::get('order_total')*0.1,2)}} €</td>

                                </tr>
                                <tr>
                                    <td><b>TOTAL</b> </td>

                                    <td><b> {{round(Session::get('order_total')*1.1,2)}} €</b></td>

                                </tr>


                            </tbody>
                        </table>

                            <div class="col-6 col-centered">
                                <button class="fa btn btn-primary col-6 col-centered fa-money" onclick="pay({{round(Session::get('order_total')*1.1,2)}})">Pagar</button>
                            </div>
                        </div>

                    </h3>
                </div>

            </div>
        </div>


    </div>

        @endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        function pay(amount) {
            var handler = StripeCheckout.configure({
                key: "{{ config('app.stripe-key') }}", // your publisher key id
                locale: 'auto',
                token: function (token) {
                    // You can access the token ID with `token.id`.
                    // Get the token ID to your server-side code for use.
                    console.log('Token Created!!');
                    console.log(token)
                    $('#token_response').html(JSON.stringify(token));

                    $.ajax({
                            url: '{{ route('store') }}',
                            method: 'post',
                            data: { tokenId: token.id, amount: amount },
                            success: (response) => {

                            console.log(response);
                    window.location = '{{ route('payed') }}'

                },
                    error: (error) => {
                        console.log(error);
                        alert('There is an error in processing.')
                    }
                })
                }
            });

            handler.open({
                name: 'Su pedido en Playa Alta',
                description: 'Numero de pedido {{Session::get('order_id')}}',
                amount: amount * 100
            });
        }
    </script>
    @stop
