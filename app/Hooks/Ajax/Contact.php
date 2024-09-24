<?php

namespace App\Hooks\Ajax;

use App\Mail\ContactMail;
use App\Models\Gsheets;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use ReCaptcha\ReCaptcha;
use stdClass;
use Themosis\Hook\Hookable;
use Themosis\Support\Facades\Ajax;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class Contact extends Hookable
{
    public function register()
    {
        Ajax::listen('contact', function () {
            global $wpdb;
            extract($_POST);
            extract($_GET);
            $response = new stdClass();

            //////No tiene relevancia donde se ponga este//////
            //DATA GOOGLE SHEETS
            //range sheet
            $rango = 'Contacto!A2:AD';

            // ReCaptcha
            // if (!empty(env('RECAPTCHA_SECRET_KEY'))) {
            //     $reCaptcha = new ReCaptcha(env('RECAPTCHA_SECRET_KEY'));
            //     $reCaptchaResp = $reCaptcha->verify(Request::get('recaptchaResponse'));
            //     if ($reCaptchaResp->isSuccess() == false) {
            //         $response->message = new stdClass();
            //         $response->message->text = __('Error en el recaptcha', 'meat');
            //         $response->message->extra_info = __('No se ha podido validar el recaptcha', 'meat');

            //         $response->success = false;
            //         wp_send_json($response);
            //         die();
            //     }
            // }


            $titleSuccess = 'Envío exitoso';
            $titleFailed = 'Error en el envío.';
            $messageFailed = 'Ha ocurrido un problema al intentar enviar tu correo.';

            $messageSuccess = 'Gracias por contactarnos';
            $table = 'contact';

            $validator = Validator::make(Request::all(), [
                'firstname'      => 'required',
                'lastname'      => 'required',
                'phone'      => 'required',
                'email' => 'required|email',
                'message' => 'required',
            ], [
                'firstname.required'     => __('El nombre es requerido.', 'meat'),
                'lastname.required'     => __('El apellido es requerido.', 'meat'),
                'phone.required'     => __('El teléfono es requerido.', 'meat'),
                'message.required'    => __('El mensaje es requerido.', 'meat'),
                'email.required'    => __('El correo electrónico es requerido.', 'meat'),
            ]);

            if ($validator->fails()) {
                $response->message = new stdClass();
                $response->message->text = __('Faltan campos requeridos', 'meat');
                $response->message->extra_info = implode('<br>', $validator->messages()->all());
                wp_send_json($response, 400);
                die();
            }

            $data = [
                'name' => Request::get('firstname') ?? '',
                'lastname' => Request::get('lastname') ?? '',
                'email' => Request::get('email') ?? '',
                'phone' => str_replace('+', '', Request::get('phone') ?? ''),
                'message' => Request::get('message') ?? '',
                'terms' => Request::get('terms') ? 'Si' : 'No',
                'date' => date('Y-m-d H:i:s'),
            ];
            // guarda en BD
            try {
                $id = DB::table($table)->insertGetId($data);
                $success = true;
                $messages[] = 'Los datos fueron almacenados.';


                /////Dentro del try cuando ya obtienen la response////
                $gsheets = (new Gsheets())->getClient($data, $rango);

                $payload = array(
                    "fields" => array(
                        array(
                            "objectTypeId" => "0-1",
                            "name" => "email",
                            "value" => $data['email']
                        ),
                        array(
                            "objectTypeId" => "0-1",
                            "name" => "firstname",
                            "value" => $data['name']
                        ),
                        array(
                            "objectTypeId" => "0-1",
                            "name" => "lastname",
                            "value" => $data['lastname']
                        ),
                        array(
                            "objectTypeId" => "0-1",
                            "name" => "phone",
                            "value" => str_replace(['+', ' ', '-'], '', $data['phone'])
                        ),
                        array(
                            "objectTypeId" => "0-1",
                            "name" => "message",
                            "value" => $data['message']
                        ),
                    ),
                );

                $payload = json_encode($payload);
                $hubspot = get_field('hubspot', 'option');
                $ch = curl_init('https://api.hsforms.com/submissions/v3/integration/submit/' . $hubspot['portal_id'] . '/' .  $hubspot['contact_form_id']);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $resultado = curl_exec($ch);
                curl_close($ch);

                $response->success = true;
                $response->message = [
                    'button' => 'Ok',
                    'text' => $messageSuccess,
                    'title' => $titleSuccess,
                ];
                try {
                    //code...
                    $emails_fm = get_field('emails', 'option');
                    $emailDest = (new Post())->getTextArray($emails_fm['emails'], 'email');
                    $emails_cc = (new Post())->getTextArray($emails_fm['emails_cc'], 'email');
                    $emails_bcc = (new Post())->getTextArray($emails_fm['emails_bcc'], 'email');

                    $general_info = get_field('mail_info', 'option');
                    $data['whatsapp'] = isset($general_info['whastapp']) && !empty($general_info['whastapp']) ? $general_info['whastapp'] : '';
                    $data['rrss_mail'] = isset($general_info['rrss_mail']) ? $general_info['rrss_mail'] : [];

                    Mail::to(Request::get('email'))->cc($emails_cc)->bcc($emails_bcc)->send(new ContactMail('Formulario de contacto exitoso #' . $id, $data));
                } catch (\Exception $e) {
                    Log::info('No se logró enviar el correo');
                    Log::error($e);
                }
            } catch (\Exception $e) {
                $messages[] = 'Error al intentar guardar los datos.';
                Log::error($e);
            }
            wp_send_json($response, 200);
            die();
        });
    }
}
