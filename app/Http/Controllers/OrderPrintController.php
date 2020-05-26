<?php

namespace App\Http\Controllers;

use App\MobileOrder;
use App\MobileOrderLines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class OrderPrintController extends Controller
{
    //
    public function printKitchenOrder($order_id)
        {
            $order = MobileOrder::find($order_id);
            $orderlines = MobileOrder::find($order_id)->mobileOrderLines;
            Log::debug('orderline: '.$orderlines);
            Log::debug('printer datos: '.config('app.kitchen-printer-ip'). ' port: '.config('app.kitchen-printer-port'));
        try {
            $connector = new NetworkPrintConnector(config('app.kitchen-printer-ip') , config('app.kitchen-printer-port'));
            $printer = new Printer($connector);
            $printer -> text( "\n \n");
            $printer->setTextSize(2, 2);
            $printer -> text("Order Number: ".$order_id. "\n");
            $printer -> text( "\n");
            $printer -> text("Mesa: ".$order->table_number. "\n");
            $printer -> text( "\n");
            foreach ($orderlines as $line){
                Log::debug('orderline: '.$line);
                $printer -> text($line->product->NAME . "\n");
            }
            $printer -> text( "\n \n");
            $printer -> cut();


            $printer -> close();
        } catch(Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }
        return view('order.payed',compact('order_id'));
    }
}
