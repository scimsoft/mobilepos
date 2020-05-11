<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Redirect,Response;
use Stripe;
class MyStripeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('payment');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        Log::debug('in function store de controller in tokenID'.$request->get('tokenId'));
        $stripe = Stripe::charges()->create([
            'source' => $request->get('tokenId'),
            'currency' => 'EUR',
            'amount' => $request->get('amount')*100 ,
        ]);

        return $stripe;
    }
}