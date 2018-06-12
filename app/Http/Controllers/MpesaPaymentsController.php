<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpesa;

class MpesaPaymentsController extends Controller
{
  public function __construct()
  {
  	$this->middleware(['auth']);
  }


    public function checkout()
{
    $repsonse = Mpesa::request(100)->from(254722000000)->usingReferenceId(115445)->transact();
}
}
