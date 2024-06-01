<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;


class OperationController extends Controller
{
    //


    public function createTransaction(Request $request)
    {
        try
        {
            $data = array(
                "description" => "Transaction for john.doe@example.com",
                "amount" => 2000,
                "currency" => array(
                    "iso" => "XOF"
                ),
                "callback_url" => "https://maplateforme.com/callback",
                "customer" => array(
                    "firstname" => "John",
                    "lastname" => "Doe",
                    "email" => "john.doe@example.com",
                    "phone_number" => array(
                        "number" => "+22997808080",
                        "country" => "bj"
                    )
                )
            );

            \FedaPay\FedaPay::setApiKey("sk_sandbox_xuAK1SpIXZjRSL8zDPSssFzE");

            $transaction =   \FedaPay\Transaction::create(array(
                "description" => "Transaction for john.doe@example.com",
                "amount" => 2000,
                "currency" => ["iso" => "XOF"],
                "callback_url" => "https://maplateforme.com/callback",
                "customer" => [
                    "firstname" => "John",
                    "lastname" => "Doe",
                    "email" => "john.doe@example.com",
                    "phone_number" => [
                        "number" => "+22964000001",
                        "country" => "bj"
                    ]
                ]
              ));
              $token = $transaction->generateToken();
              $result = response()->json([
                'url' => $token ['url'],
                'token' => $token ['token'],
                'operatin_id' => $transaction['id'],
              ]);
              log::info(  $result);

                log::info("approved");
                return response()->json([
                    'data' => $result,
                    'status' => "success",  'message' => "succes",
                ], 200);


        }
        catch(Exception $e)
        {
            log::error($e);
        }
    }

    
    public function getStatus(Request $request, $id)
    {
        try
        {

           // $request->operatiom_id = 245841;
           \FedaPay\FedaPay::setApiKey("sk_sandbox_xuAK1SpIXZjRSL8zDPSssFzE");
            $transaction = \FedaPay\Transaction::retrieve($id);
            log::info($transaction);
            if ($transaction->status == "approved") {
              log::info("approved");
              return response()->json([
                  'data' =>"",
                  'status' =>$transaction->status ,  'message' => "succes",
              ], 200);
        } }
        catch(Exception $e)
        {
            log::error($e);
        }

    }
}
