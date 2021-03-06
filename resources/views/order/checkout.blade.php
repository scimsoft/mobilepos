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

                                    <td> @money(Session::get('order_total')) </td>

                                </tr>
                                <tr>
                                    <td>IVA </td>

                                    <td> @money(Session::get('order_total')*0.1) </td>

                                </tr>
                                <tr>
                                    <td><b>TOTAL</b> </td>

                                    <td><b> @money(Session::get('order_total')*1.1)</b></td>

                                </tr>


                            </tbody>
                        </table>

                            {{--<div class="col-6 col-centered">--}}
                                {{--<button class="btn btn-primary fa fa-credit-card" onclick="pay({{round(Session::get('order_total')*1.1,2)}})">&nbsp; Pagar con tarjeta</button>--}}
                            {{--</div>--}}
                        {{--<div class="col-6 col-centered">&nbsp;--}}
                           {{--</div>--}}
                        {{--<div class="col-6 col-centered">--}}
                            {{--<a class="btn btn-primary fa fa-paypal" href="/paypal/{{round(Session::get('order_total')*1.1,2)}}" >&nbsp; Pagar con paypal</a>--}}
                        {{--</div>--}}

                            <div id="paypal-button-container"></div>

                        {{--<div class="col-6 col-centered">
                            <a class="btn btn-primary fa fa-waiter" href="/order/callwaiter/{{Session::get('order_id')}}" >&nbsp; llamar la camarera</a>
                        </div>--}}
                    Con cualquier duda acude a las camareras.

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
    <script src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.client_id') }}&currency=EUR"></script>
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
        paypal.Buttons({
            createOrder: function(data, actions) {
                // This function sets up the details of the transaction, including the amount and line item details.
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '{{Session::get('order_total')*1.1}}'
                        }

                    }]
                });
            },
            onApprove: function(data, actions) {
                // This function captures the funds from the transaction.
                return actions.order.capture().then(function(details) {
                    // This function shows a transaction success message to your buyer.
                    //alert('Transaction completed by ' + details.payer.name.given_name);
                    location.href='paypalpayed/{{session('order_id')}}'  ;
                });
            },
            onCancel: function(data){

            }
        }).render('#paypal-button-container');

    </script>
    @stop
