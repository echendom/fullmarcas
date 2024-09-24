<?php

namespace App\Http\Controllers;

use App\Mail\FlowCompletedMail;
use App\Models\Post;
use App\Models\TransBank;
use App\Services\BillingService;
use App\Services\TransBankService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use stdClass;

class TransbankController extends Controller
{
    public function confirmation(Request $request)
    {
        //Recibimos la respuesta de confirmación del pago en Transbank
        if(!is_null($request->TBK_TOKEN)){
            DB::table('registration')->where('token_tbk', $request->TBK_TOKEN)->update(['status_tbk' => TransBank::STATUS_FAILED , 'orden_compra_tbk' => $request->TBK_ORDEN_COMPRA, 'id_sesion_tbk' => $request->TBK_ID_SESION]);
            return view('pages.payment-error');

        }

        if (!is_null($request->token_ws)) {
            //Si el token no es vacío, se procede a validar el pago con
            //la API de Transbank.
            $response = TransBankService::confirmTransaction($request->token_ws);
            if (isset($response['response_code']) && $response['response_code'] == 0) {
                $registration = DB::table('registration')->where('token_tbk', $request->token_ws)->first();
                $payment = [
                    "metodo" => "WebPay",
                    "idpago" => $response['auth_code'],
                    "pagador" => $response['card'],
                    "total" => $registration->mark_total_price,
                    "estado" => $response['status'] == TransBank::STATUS_SUCCESSFUL || $response['status'] == TransBank::STATUS_AUTHORIZED  ? "Pagado" : $response['status'],
                ];

                $payment = json_encode($payment);
                $dt = Carbon::now();
                DB::table('registration')->where('token_tbk', $request->token_ws)->update(['status_tbk' => TransBank::STATUS_SUCCESSFUL, 'step' => 'finished', 'payment' => $payment, 'date_finish' => $dt->toDateString(),'updated_at' => $dt->toDateString()]);
                /*Aquí iría el código que se ejecutaría si la transacción fue
                *aprobada por el usuario*/

                $fields = [
                    'trademark_name' => $registration->mark_denomination,
                    'summary' => [
                        'services' => json_decode($registration->mark_services),
                        'total' => '$' . number_format($registration->mark_total_price, 0, '', '.')
                    ]
                ];
                if(!empty($fields['summary']['services'])){
                        $array = [];
                    foreach ($fields['summary']['services'] as $value) {
                        $details = [];
                        if(!empty($value->details)){
                            foreach ($value->details as $item) {
                                $item->price = '$' . number_format($item->price, 0, '', '.');
                                $item->net_price = '$' . number_format($item->net_price, 0, '', '.');
                                $item->title = '';
                                $details[] = (array) $item;
                            }
                            $value->details = $details;
                        }
                        $array[] = (array) $value;
                    }

                    $fields['summary']['services'] = $array;
                }
                $holders = [];
                if (!empty($registration->mark_holders)) {
                    $holders = json_decode($registration->mark_holders);
                }

                    $classes = json_decode($registration->mark_classes) ?? [];

                    // Creamos un cliente Guzzle
                    $client = new Client();
                    // Realizamos la petición POST
                    $mark = new stdClass();
                    $mark->denominacion =  $registration->mark_denomination;
                    $mark->tipo =  $registration->mark_type;
                    $mark->categoria =  str_replace(';',',',$registration->mark_category);
                    $mark->clases =  $classes;
                    $mark->negocio = $registration->mark_class_text;
                    $mark->image_detalle = $registration->image_extra_info;
                    $mark->cobertura =  "";

                    if(!empty($registration->mark_image)){
   
                        $mark->image = $registration->mark_image;
                        
                    }

                    $similarity = new stdClass();
                    $similarity->estado = $registration->mark_status;
                    $similarity->marca_mensaje = $registration->mark_message;
                    $similarity->dominio = $registration->mark_domain_status;
                    $similarity->dominio_mensaje = $registration->mark_domain_message;

                    $services = json_decode($registration->mark_services);

                    $services = array_map( function($item){

                        $service = new stdClass();

                        $service->id = $item->id;
                        $service->resumen = $item->title;
                        $service->servicio = $item->key;
                        $service->grupo = $item->group;
                        $service->opcional = $item->optional;
                        $service->valorNeto = $item->net_price;
                        $service->valorDescuento = $item->discount_value;
                        $service->valorDescuentoPorcentaje = $item->discount_perc;
                        $service->valorIva = $item->price_iva;
                        $service->valorTotal = $item->price;
                        return $service;
                    }, $services );
                    $data = [
                        "id" => $registration->mark_id,
                        "email" => $registration->email,
                        "telefono" => $registration->telefono,
                        "marca" => $mark,
                        "similitud" => $similarity,
                        "titulares" => $holders,
                        "pago" => json_decode($payment),
                        "servicios" => $services
                    ];

                    try {
                        //code...
                        $response = $client->post(env('REGISTRATION_URL_API') . "/marcas/registrar", [
                            "json" => $data
                        ]);
                        
                        // Verificamos el estado de la respuesta
                        if ($response->getStatusCode() == 200) {
                            // La petición se ha realizado correctamente
                            $body = $response->getBody()->getContents();
                            $body = json_decode($body);
    
                            $general_info = get_field('mail_info', 'option');
                            BillingService::generateBilling($registration->mark_id) ?? '';
                            $registration = DB::table('registration')->where('mark_id', $registration->mark_id)->first();
                            $link_bill = $registration->bill_url;
                            $data_email = [
                                'mark_denomination' => $registration->mark_denomination,
                                'mark_services' => json_decode($registration->mark_services),
                                'mark_total_price' => $registration->mark_total_price,
                                'link_bill' => $link_bill,
                                'whatsapp' => isset($general_info['whastapp']) && !empty($general_info['whastapp']) ? $general_info['whastapp'] : '',
                                'rrss_mail' => isset($general_info['rrss_mail']) ? $general_info['rrss_mail'] : []
    
                            ];
    
                            try {
                                //code...
                                $emails_fm = get_field('emails', 'option');
                                $emails_bcc = (new Post())->getTextArray($emails_fm['emails_bcc'], 'email');
    
                                $holders = json_decode($registration->mark_holders);
                                $emails_cc = [];
                                if(is_array($holders) && !empty($holders)){
                                    foreach ($holders as $holder) {
                                        if($holder->email != $registration->email){
                                            $emails_cc[] =  $holder->email;
                                        }
                                    }
                                }
                
                                    Mail::to($registration->email)->cc($emails_cc)->bcc($emails_bcc)->send(new FlowCompletedMail('Solicitud de registro de Marca - ' . $registration->mark_denomination, $data_email));
                                    
                
                            } catch (\Exception $e) {
                                Log::info( 'No se logró enviar el correo');
                                Log::error($e);
                            }
    
    
                            $payload = array(
                                "fields" => array(
                                    array(
                                        "objectTypeId" => "0-1",
                                        "name" => "email",
                                        "value" => $registration->email
                                    ),
                                    array(
                                        "objectTypeId" => "0-1",
                                        "name" => "mark_id",
                                        "value" => $registration->mark_id
                                    ),
                                    array(
                                        "objectTypeId" => "0-1",
                                        "name" => "mark_denomination",
                                        "value" => $registration->mark_denomination
                                    ),
                                    array(
                                        "objectTypeId" => "0-1",
                                        "name" => "mark_category",
                                        "value" => $registration->mark_category
                                    ),
                                    array(
                                        "objectTypeId" => "0-1",
                                        "name" => "mark_image",
                                        "value" => $registration->mark_image
                                    ),
                                    array(
                                        "objectTypeId" => "0-1",
                                        "name" => "mark_status",
                                        "value" => $registration->mark_status
                                    ),
                                    array(
                                        "objectTypeId" => "0-1",
                                        "name" => "mark_domain",
                                        "value" => $registration->mark_domain
                                    ),
                                    array(
                                        "objectTypeId" => "0-1",
                                        "name" => "mark_domain_status",
                                        "value" => $registration->mark_domain_status
                                    ),
                                )
                            );
    
    
                            $payload = json_encode($payload);
                            $hubspot = get_field('hubspot', 'option');
    
                            $ch = curl_init('https://api.hsforms.com/submissions/v3/integration/submit/' . $hubspot['portal_id'] . '/' .  $hubspot['register_form_id']);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $resultado = curl_exec($ch);
                            curl_close($ch);
    
    
                            $response = [
                                'status_code' => 200,
                                'id' => $body->id,
                                'status' => $body->estado,
                                'message' => $body->mensaje,
                            ];
                          
                        } else {
                            // La petición ha fallado
                            DB::table('registration')->where('token_tbk', $request->token_ws)->update(['status_tbk' => TransBank::STATUS_FAILED]);
                        }
    
                    
                    return view('pages.trademark-registration-typ', compact('fields'));
                    } catch (\Throwable $th) {

                        Log::error($th->getMessage());
                        return view('pages.payment-error');

                    }
            } elseif (isset($response['response_code']) && $response['response_code'] == 1) {
                DB::table('registration')->where('token_tbk', $request->token_ws)->update(['status_tbk' => TransBank::STATUS_FAILED]);

                return view('pages.payment-error');
            } else {
                DB::table('registration')->where('token_tbk', $request->token_ws)->update(['status_tbk' => TransBank::STATUS_FAILED]);

                return view('pages.payment-error');

                /*Aquí iría el código que se ejecutaría si hubiera algún
                        error en la transacción*/
            };
        } else {
            DB::table('registration')->where('token_tbk', $request->token_ws)->update(['status_tbk' => TransBank::STATUS_CANCELLED]);

            return view('pages.payment-error');
        }
    }
}
