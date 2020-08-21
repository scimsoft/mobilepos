<?php

namespace App\Http\Controllers;

use App\MobileOrder;
use App\MobileOrderLines;
use App\UnicentaModels\SharedTicket;
use App\UnicentaModels\SharedTicketProduct;
use App\UnicentaModels\TicketLines;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Throwable;
use const true;

class OrderPrintController extends Controller
{

    public function printKitchenOrder($order_id)
    {
        $printkitchen=false;
        $printbarra=false;
        $kitchenprinterlines = "COCINA\n\n\n"  . "Mesa: " . Session::get('table_number') . "\n\n";
        $barprinterlines =      "BARRA\n\n\n"  . "Mesa: " . Session::get('table_number') . "\n\n";

        $orderlines = MobileOrderLines::where('mobile_order_id', $order_id)->where('printed', 0)->get();
        if (Session::get('table_number') > 0) {
            $this->insertSharedTicket($order_id);
        }
        Log::debug('before printto  with :  order_id' . $order_id);
        foreach ($orderlines as $orderline) {
            if ($orderline->product->printto == '2') {
                Log::debug('in printto cocina with: '. $orderline->product->name);
                $printkitchen=true;
                $kitchenprinterlines .= $orderline->product->name . "\n";
                $orderline->printed = 1;
                $orderline->save();
            } else {
                Log::debug('in printto barra with: '. $orderline->product->name);
                $printbarra=true;
                $barprinterlines .= $orderline->product->name . "\n";
                $orderline->printed = 1;
                $orderline->save();
            }
        }

        //dd($barprinterlines);
        if($printbarra==true)$this->printTicket($barprinterlines);
        if($printkitchen==true)$this->printTicket($kitchenprinterlines);



        return view('order.payed', compact('order_id'));
    }

    public function printPedirCuenta($id){
        $order = MobileOrder::find($id);
        $order_id=$order->id;
        $printerlines="\n BARRA \n\n La mesa: ". $order->table_number . "\n \n Pide la CUENTA";
        $this->printTicket($printerlines);
        Session::put('status','La camarera acerca la cuenta');
        return view('order.payed', compact('order_id'));
    }

    /**
     * @param $order_id
     */
    public function printTicket($lines)
    {

        Log::debug('printerline: ' . $lines);
        Log::debug('printer datos: ' . config('app.kitchen-printer-ip') . ' port: ' . config('app.kitchen-printer-port'));
        try {
            $connector = new NetworkPrintConnector(config('app.kitchen-printer-ip'), config('app.kitchen-printer-port'), 3);
            $printer = new Printer($connector);
            $printer->text("\n \n");
            $printer->setTextSize(2, 2);
            $printer->text($lines);
            $printer->text("\n \n");
            $printer->cut();
            $printer -> getPrintConnector() -> write(PRINTER::ESC . "B" . chr(4) . chr(1));
            $printer -> getPrintConnector() -> write(PRINTER::ESC . "B" . chr(4) . chr(1));
            $printer->close();
        } catch (Throwable $e) {
            return abort('503', 'No se puede imprimir el pedido, avisa a la camarera por favor');
        }
    }

    public function insertSharedTicket($order_id)
    {

        $deleterow = false;
        $sharedTicket = new SharedTicket();
        $sharedTicket->m_User = ['m_sId' => '0', 'm_sName' => 'Administrator'];
        $activeCash = DB::select('Select money FROM closedcash where dateend is null')[0];
        $sharedTicket->m_sActiveCash = $activeCash->money;


        $order = MobileOrder::find($order_id);
        $orderlines = $order->mobileOrderLines;
        $count = 0;

        $oldticketlines = DB::Connection('mysql2')->select('Select content from sharedtickets where id ='. $order->table_number);
        //dd(json_decode($oldticketlines[0]->content)->m_aLines);
        if(count($oldticketlines)>0) {
            $productlists = json_decode($oldticketlines[0]->content)->m_aLines;
            foreach ($productlists as $productlist) {
                $reference = $productlist->attributes->{'product.reference'};
                $name = $productlist->attributes->{'product.name'};
                $code = $productlist->attributes->{'product.code'};
                $categoryid = $productlist->attributes->{'product.categoryid'};
                $printto = $productlist->attributes->{'product.printer'};
                $pricesell = $productlist->price;
                $id = $productlist->productid;
                $tempProduct = new SharedTicketProduct($reference, $name, $code, $categoryid, $printto, $pricesell, $id);

                $sharedTicket->m_aLines[] = ((new TicketLines($sharedTicket, $tempProduct, $count)));
                $count = $count + 1;
            }
        }

        foreach ($orderlines as $orderline) {
            if ($orderline->printed == 1)
            {
                $deleterow = true;
            }else {
                $sharedTicket->m_aLines[] = ((new TicketLines($sharedTicket, $orderline->product, $count)));
                Log::debug('Adding ticketlines for Insert ' . $count);
                $count = $count + 1;
            }

        }


        if ($deleterow ==true) {
            $SQLString = "DELETE from sharedtickets where id=" . $order->table_number;
            DB::Connection('mysql2')->delete($SQLString);
        }
        //INSERT sharedticket data
        $SQLString = "INSERT into sharedtickets VALUES ($order->table_number,'Gerrit','" . json_encode($sharedTicket) . "',0,0,null)";
        Log::debug('INSERT SQLSTRING sharedticket: '. $SQLString);
        DB::Connection('mysql2')->insert($SQLString);

        //Set table ocupied and link to order
        $SQLString = "UPDATE places SET waiter = 'app', ticketid = '" . $sharedTicket->m_sId . "', occupied = '" . Carbon::create($sharedTicket->m_dDate) . "' WHERE (id = " . $order->table_number . ")";
        //Log::debug('SQLSTRING UPDATE places : '. $SQLString);
        DB::Connection('mysql2')->insert($SQLString);


        //dd(json_decode(json_encode($sharedTicket)));
    }
    public function printPayedTicket($id){
        $order=MobileOrder::find($id);
        $order->status=2;
        $order->save();
        $order_id = $order->id;
        $printLines= "\n BARRA \n\n El order de la mesa ".$order->table_number." esta pagado por PayPal \n\n";
        //dd($printLines);
        $this->printTicket($printLines);

               return view('order.payed', compact('order_id'));
    }
}
