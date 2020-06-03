<?php

namespace App\Http\Controllers;

use App\MobileOrder;

use App\MobileOrderLines;
use App\UnicentaModels\SharedTicket;

use App\UnicentaModels\TicketLines;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function sem_get;

class SharedTicketController extends Controller
{
    //
    private $content;
    public function getSharedTicketID($tableID)
    {

        $sharedTicket = DB::select("SELECT * FROM sharedtickets WHERE id=".$tableID);
        $this->content = json_decode($sharedTicket[0]->content);


        dd($this->content);


    }

    public function insertSharedTicket($order_id){


        $sharedTicket = new SharedTicket();
        $sharedTicket->m_User = ['m_sId' => '0','m_sName'=>'Administrator'];
        $activeCash = DB::select('Select money FROM closedcash where dateend is null')[0];
        $sharedTicket->m_sActiveCash=$activeCash->money;


        $order = MobileOrder::find($order_id);
        $orderlines = $order->mobileOrderLines;
        $count = 0;
        foreach ($orderlines as $orderline){


            $sharedTicket->m_aLines[]=((new TicketLines($sharedTicket,$orderline,$count)));
            $count = $count+1;
        }

        //INSERT sharedticket data
        $SQLString = "INSERT into sharedtickets VALUES ($order->table_number,'Gerrit','".json_encode($sharedTicket)."',0,0,null)";
        //Log::debug('SQLSTRING sharedticket: '. $SQLString);
        DB::insert($SQLString);

        //Set table ocupied and link to order
        $SQLString = "UPDATE places SET waiter = 'app', ticketid = '".$sharedTicket->m_sId."', occupied = '".Carbon::create($sharedTicket->m_dDate)."' WHERE (id = ".$order->table_number.")";
        //Log::debug('SQLSTRING UPDATE places : '. $SQLString);
        DB::insert($SQLString);


        dd(json_decode(json_encode($sharedTicket)));
    }
}
