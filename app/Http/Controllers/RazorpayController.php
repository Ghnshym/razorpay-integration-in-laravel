<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Session;
use Redirect;

class RazorpayController extends Controller
{
    public function razorpay()
    {        
        return view('index');
    }

    public function payment(Request $request)
    {        
        $input = $request->all();        
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if (count($input) && !empty($input['razorpay_payment_id'])) 
        {
            try 
            {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount'])); 

                // Payment successful
                $this->setSuccessMessage('Payment successful, your order will be dispatched in the next 48 hours.');

            } 
            catch (\Exception $e) 
            {
                // Payment failed
                $this->setErrorMessage($e->getMessage());
            }            
        }
        
        return redirect()->back();
    }

    private function setSuccessMessage($message)
    {
        Session::put('success', $message);
    }

    private function setErrorMessage($message)
    {
        Session::put('error', $message);
    }
}