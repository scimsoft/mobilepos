<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<style>
    #overlay {
        background-color: rgba(255, 255, 255, 0.5);

        position: fixed;
        height: 100%;
        width: 100%;
        z-index: 5000;
        top: 0;
        left: 0;
        float: left;
        text-align: center;
        padding-top: 25%;
    }
</style>
<div id="overlay">
    <img src="/img/loader.gif" alt="Loading" /><br/>
    Loading....
</div>

<div id="app">
        <nav class="navbar navbar-expand-md navbar-light fixed-top bg-white shadow-sm ">
            <span class="container">

                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/img/logo.png" width="32px" class="img-fluid">
                    {{ config('app.name', 'Laravel') }}
                </a>
                @if(Auth::check() && Auth::user()->isAdmin())
                    <a href="/cleanhome" class="btn btn-warning">mesas</a>
                @endif


                    <a id="basketLink" href="/basket"  >


                        <button type="button" class="btn btn-labeled btn-success" id="ordertotal">
                <span class="btn-label"><i class="fa fa-shopping-cart shopping-cart"></i></span>  0,00€
                        </button>

                    </a>
            </span>





        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @yield('scripts');


    <script>

        jQuery(document).ready(function () {
            // ORDER TOTAL IN APP BLADE
            var orderTotalBasket = 0;
            setOrderTotal();






        });
        function setOrderTotal() {
                    @if(session()->has('order_id'))
            var order_id = '{{Session::get('order_id')}}';

            jQuery.ajax({
                    url: '/total/ajax/' + order_id,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {

                        orderTotalBasket= (data * 1.1).toFixed(2) + "€";
                        $('#ordertotal').html('<span class="btn-label"><i class="fa fa-shopping-cart"></i></span>&nbsp;'+ orderTotalBasket);
                        document.getElementById('basketLink').setAttribute('href', '/basket/' + order_id);
                        jQuery('#overlay').fadeOut();
                        return orderTotalBasket;
                    }

                }
            );
            @else
                jQuery('#overlay').fadeOut();
            @endif

        }




    </script>
    <script>
        jQuery(document).ready(function(){

        });
    </script>

</body>
</html>
