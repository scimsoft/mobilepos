<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stripe Demo</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="jumbotron text-center">
                <h1>Stripe Payment Demo</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12"><pre id="token_response"></pre></div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <button class="btn btn-primary btn-block" onclick="pay(10)">Pay $10</button>
        </div>
        <div class="col-md-4">
            <button class="btn btn-success btn-block" onclick="pay(50)">Pay $50</button>
        </div>
        <div class="col-md-4">
            <button class="btn btn-info btn-block" onclick="pay(100)">Pay $100</button>
        </div>
    </div>
</div>
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

                        console.log(response)

            },
                error: (error) => {
                    console.log(error);
                    alert('There is an error in processing.')
                }
            })
            }
        });

        handler.open({
            name: 'Some Site',
            description: '10 widgets',
            amount: amount * 100
        });
    }
</script>
</body>
</html>