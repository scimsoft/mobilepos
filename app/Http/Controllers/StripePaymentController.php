<?php

namespace App\Http\Controllers;

use App\MobileOrder;
use function redirect;
use Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class StripePaymentController extends Controller
{
    //
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
        try {
            $stripe = Stripe::charges()->create([
                'source' => $request->get('tokenId'),
                'currency' => 'EUR',
                'amount' => $request->get('amount'),
            ]);
            Session::put('status','Su pedido esta en curso, gracias por su confianza');
            $this->setOrderPaid();

            Log::debug('finishing payment ');
            return 'SUCCESS';
        } catch (Exception $e) {
            Session::put('status','El pago no se ha finalizado con excito, paga en la barra.');
            return 'FAIL';
        }
    }

    public function payed(){
        $order_id=Session::get('order_id');
        Session::remove('order_id');

        return redirect('/prepareorder/'.$order_id);
    }

    public function setOrderPaid(){
        $order_id = Session::get('order_id');
        $order = MobileOrder::find($order_id);
        $order -> status = '2';
        $order->save();
    }
}
