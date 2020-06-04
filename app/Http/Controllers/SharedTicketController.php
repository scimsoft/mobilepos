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


}
