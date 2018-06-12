<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Validator;

class StripePaymentsController extends Controller
{
    public function __construct()
    {
        return $this->middleware(['auth']);
    }

    public function stripePaymentForm()
    {
    	return view('payments.stripe.payment_form',['title'=>'Complete Payment with Stripe']);
    }

    public function stripePaymentProcessor(Request $request)
    {
    	\Stripe\Stripe::setApiKey ( 'sk_test_SvQolEfnucDZErEPRt5Rla6c' );
    try {
        \Stripe\Charge::create ( array (
                "amount" => 300 * 100,
                "currency" => "usd",
                "source" => $request->input ( 'stripeToken' ), // obtained with Stripe.js
                "description" => "Test payment." 
        ) );
        //Session::flash ( 'success-message', 'Payment done successfully !' );
        return Redirect::back()->with('message','success-message', 'Payment done successfully !');
    } catch ( \Exception $e ) {
        Session::flash ( 'fail-message', "Error! Please Try again." );
        return Redirect::back ();
    }

    }
}


