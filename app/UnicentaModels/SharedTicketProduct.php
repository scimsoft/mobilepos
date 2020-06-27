<?php
/**
 * Created by PhpStorm.
 * User: Gerrit
 * Date: 24/06/2020
 * Time: 11:53
 */

namespace App\UnicentaModels;

class SharedTicketProduct
{

public $reference;
public $name;
public $code;
public $category;
public $printto;
public $pricesell;
public $id;

    /**
     * SharedTicketProduct constructor.
     * @param $reference
     * @param $name
     * @param $code
     * @param $category
     * @param $printto
     */
    public function __construct($reference, $name, $code, $categoryid, $printto, $pricesell, $id)
    {
        $this->reference = $reference;
        $this->name = $name;
        $this->code = $code;
        $this->category = $categoryid;
        $this->printto = $printto;
        $this->pricesell = $pricesell;
        $this->id = $id;

    }


    function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
        return [

            "product.taxcategoryid" => "001",
            "product.warranty" => "false",
            "product.memodate" => "2018-01-01 00:00:01.0",
            "product.verpatrib" => "false",
            "product.reference" => $this->reference,
            "product.name" => $this->name,
            "product.com" => "false",
            "product.code" => $this->code,
            "product.constant" => "false",
            "ticket.updated" => "false",
            "product.category" => $this->category,
            "product.printer" => $this->printto,
            "product.vprice" => "false",



        ];
    }


}