<?php
/**
 * User: Jesús Ruíz
 * Date: 11-01-24
 */

 namespace App\Services;

use Illuminate\Support\Facades\Log;
use Transbank\Webpay\WebpayPlus\Transaction;


class TransBankService
{

    public static function createTransaction($amount, $order_id){
        $transaction = new Transaction();
        TransBankService::configureTransbank($transaction);
        $session_id = session_create_id();
        $return_url = route('tbk.webpay.confirmation');
        $response = $transaction->create($order_id, $session_id, $amount, $return_url);

        return ['url' => $response->url . '?token_ws=' . $response->token, 'token_tbk' => $response->token];

    }

    public static function confirmTransaction($token){
        $transaction = new Transaction();
        TransBankService::configureTransbank($transaction);
        try {
          $response_tbk = $transaction->commit($token); 
        } catch (\Throwable $th) {
          if(property_exists($th,'message')){
            Log::error($th->getMessage());
            return [];
          }
        }


        $vci = '';
        if(isset($response_tbk->vci)){
            switch ($response_tbk->vci) {
                case "TSY":
                  $vci = "Autenticación Exitosa";
                  break;
                case "TSN":
                  $vci = "Autenticación Rechazada";
                  break;
                case "NP":
                  $vci = "No Participa, sin autenticación";
                  break;
                case "U3":
                  $vci = "Falla conexión, Autenticación Rechazada";
                  break;
                case "INV":
                  $vci = "Datos Inválidos";
                  break;
                case "A":
                  $vci = "Intentó";
                  break;
                case "CNP1":
                  $vci = "Comercio no participa";
                  break;
                case "EOP":
                  $vci = "Error operacional";
                  break;
                case "BNA":
                  $vci = "BIN no adherido";
                  break;
                case "ENA":
                  $vci = "Emisor no adherido";
                  break;
                default:
                  $vci = "Valor desconocido";
                  break;
              }
        }

        $response = [
            'vci' => $vci,
            'status' => $response_tbk->status,
            'response_code' => $response_tbk->responseCode,
            'auth_code' => $response_tbk->buyOrder,
            'session_id' => $response_tbk->sessionId,
            'card' => $response_tbk->getCardDetail(),
            'balance' => $response_tbk->getBalance(),
        ];

        return $response;
        
    }

    public static function statusTransaction($token){
        $transaction = new Transaction();
        TransBankService::configureTransbank($transaction);
        $response_tbk = $transaction->commit($token);
        $vci = '';
        if(isset($response_tbk->vci)){
            switch ($response_tbk->vci) {
                case "TSY":
                  $vci = "Autenticación Exitosa";
                  break;
                case "TSN":
                  $vci = "Autenticación Rechazada";
                  break;
                case "NP":
                  $vci = "No Participa, sin autenticación";
                  break;
                case "U3":
                  $vci = "Falla conexión, Autenticación Rechazada";
                  break;
                case "INV":
                  $vci = "Datos Inválidos";
                  break;
                case "A":
                  $vci = "Intentó";
                  break;
                case "CNP1":
                  $vci = "Comercio no participa";
                  break;
                case "EOP":
                  $vci = "Error operacional";
                  break;
                case "BNA":
                  $vci = "BIN no adherido";
                  break;
                case "ENA":
                  $vci = "Emisor no adherido";
                  break;
                default:
                  $vci = "Valor desconocido";
                  break;
              }
        }

        $response = [
            'vci' => $vci,
            'status' => $response_tbk->status,
            'response_code' => $response_tbk->responseCode,
            'auth_code' => $response_tbk->authorizationCode,
            'session_id' => $response_tbk->sessionId,
        ];

        return $response;
        
    }

    public static function configureTransbank($transaction): void
    {

      if(env('TBK_TEST_MODE')){
        $transaction->configureForIntegration(env('TBK_COMMERCE_CODE'), env('TBK_API_KEY'));
      } else {
        $transaction->configureForProduction(env('TBK_COMMERCE_CODE'), env('TBK_API_KEY'));
      }

    }

}