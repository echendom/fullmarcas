<?php

/**
 * User: Jesús Ruíz
 * Date: 11-01-24
 */

namespace App\Services;

use App\Mail\BillErrorMail;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use SoapClient;
use SoapFault;
use stdClass;

class BillingService
{
    public static function generateBilling($mark_id)
    {
        $wsdl = env('BILLING_URL');
        $iva = 19;

        $registration =  DB::table('registration')->where('mark_id', $mark_id)->first();

        if (is_null($registration)) {
            Log::error('No se encontró el registro con el ID proporcionado.');
            die();
        }
        $holder = (json_decode($registration->mark_holders))[0];
        // Log::info($holder);
        $rut = str_replace(['.','-'], '', $holder->rut);
        // Obtener la longitud del string
        $len = strlen($rut);

        // Posición del caracter donde se insertará el "-"
        $pos = $len - 1;

        // Insertar "-" usando la función substr_replace
        $new_rut = substr_replace($rut, "-", $pos, 0);
        $services = json_decode($registration->mark_services, true);
        $total = $registration->mark_total_bill_price;
        $registration_id = $registration->id;
        $total_desc = 0;
        $total_bill = 0;
        $total_perc_desc = 0;
        Log::info('Serial: ' . $registration_id);

        // $registration_id = (env('FACTURACION_PROD_MODE')) ? str_pad("" . $registration->id, 9, "0", STR_PAD_LEFT) : "999226$registration_id";
        $registration_id = 0;

        // $registration_id = str_pad("" . $registration->id, 9, "0", STR_PAD_LEFT);
        Log::info('giro: '. $holder->giro);
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $registration->date_finish, 'America/Santiago')->locale('es')->isoFormat('YYYY-MM-DD');
        $fullname = $holder->nombre .' '. $holder->apellido;
        Log::info($fullname);
        $datos = array(
            '->Encabezado<-',
            "34;$registration_id;$date;0;0;$new_rut;$fullname;$holder->giro;$holder->direccion;$holder->comuna;$holder->comuna;$holder->email;",
            '->Totales<-',
            "_perc_total;_perc_value_total;0;0;0;_total_bill;0;0;_total_bill;",
            '->Detalle<-',
        );
        Log::info($datos);
        $id = 1;
        foreach ($services as $key => $service) {
            if ($service['on_bill'] == "true") {
                $description_long = str_replace(['“', '”'], '"', $service['key']);
                $description_short = substr($description_long, 0, strpos($description_long, " "));
                $description_long = ucfirst(substr($description_long, strpos($description_long, " ") + 1));

                $price = $service['price'];
                $service_id = $service['id'];
                $net_price = $service['net_price'];
                $discount_value = $service['discount_value'];
                $discount_perc = $service['discount_perc'];

                $total_desc += (int) $discount_value;
                $total_perc_desc += (int) $discount_perc;
                $total_bill += (int)$price;
                $datos[] = "$id;$service_id;$description_short;1;$net_price;$discount_perc;$discount_value;0;0;$price;$price;INT1;UN;$description_long;";
                $id++;
            }
        }
        $datos[3] = str_replace('_perc_total', "" . $total_perc_desc, $datos[3]);
        $datos[3] = str_replace('_perc_value_total', "" . $total_desc, $datos[3]);
        $datos[3] = str_replace('_total_bill', "" . $total_bill, $datos[3]);
        $contenido_archivo = implode("\n", $datos);
        // Crea el archivo

        $time = time();
        Storage::disk('public')->put('facturas/' . $time . '-factura.txt', $contenido_archivo);
        $file_path = Storage::disk('public')->path('facturas/' . $time . '-factura.txt');
        $file_url = (Storage::disk('public')->url('facturas/' . $time . '-factura.txt'));
        $b64 = base64_encode(file_get_contents($file_path));
        try {
            /* Creamos una instancia del cliente SOAP */
            $client = new SoapClient($wsdl);
            /* Definimos los parametros a pasar al servicio */
            $params = array(
                'login' => array(
                    'Usuario' => base64_encode(env('BILLING_USER')),
                    'Rut' => base64_encode(env('BILLING_RUT')),
                    'Clave' => base64_encode(env('BILLING_PASS')),
                    'Puerto' => base64_encode("0"),
                    'IncluyeLink' => "1"
                ),
                'file' => $b64,
                'IncluyeLink' => "1",
                'formato' => "1"
            );
            Log::info(json_encode($params));
            /* Invocamos el Web Service, Metodo: Procesar */
            $response = $client->Procesar($params);

            preg_match('/<urlOriginal>(.*?)<\/urlOriginal>/', $response->ProcesarResult, $matches);

            $link = !empty($matches) ? base64_decode($matches[1]) : '';
            $link = str_replace('http://', 'https://', $link);
            DB::table('registration')->where('mark_id', $mark_id)->update(['bill_url' => $link]);

            $xml = simplexml_load_string($response->ProcesarResult);

            $response_xml = $xml->xpath('//Resultado');
            if(isset($response_xml[0]) && $response_xml[0] . '' == 'False'){
                $detail = $xml->xpath('//Detalle');
                $error = isset($detail[0]->Documento->Error) ? $detail[0]->Documento->Error : '';
                $emails_fm = get_field('emails', 'option');
                $emailDest = (new Post())->getTextArray($emails_fm['emails'], 'email');
                $emails_bcc = (new Post())->getTextArray($emails_fm['emails_bcc'], 'email');
                $general_info = get_field('mail_info', 'option');
                $data = [
                    'id' => $registration->id,
                    'bill_file' => $file_url,
                    'error' => $error,
                    'rrss_mail' => isset($general_info['rrss_mail']) ? $general_info['rrss_mail'] : []
                ];
                Mail::to($emailDest)->bcc($emails_bcc)->send(new BillErrorMail('Error al generar factura - ' . $registration->id, $data));
            }

            Log::info(json_encode($response));
            return $link;          //Mandar correo con el link;
        } catch (SoapFault $e) {
            $emails_fm = get_field('emails', 'option');
            $emailDest = (new Post())->getTextArray($emails_fm['emails'], 'email');
            $emails_bcc = (new Post())->getTextArray($emails_fm['emails_bcc'], 'email');

            $data = [
                'id' => $registration->id,
                'bill_file' => $file_url,
                'error' => $e->getMessage()
            ];
            Mail::to($emailDest)->bcc($emails_bcc)->send(new BillErrorMail('Error al generar factura - ' . $registration->id, $data));

            Log::info($e->getMessage());
        }

        Log::info('end BillingService');
    }
}
