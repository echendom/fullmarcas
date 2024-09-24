<?php

namespace App\Hooks\Ajax;

use App\Helpers\OAuthHelper;
use App\Mail\FlowCompletedMail;
use App\Mail\ForgottenCartMail;
use App\Models\Gsheets;
use App\Models\Post;
use App\Services\ApiClientService;
use App\Services\BillingService;
use App\Services\TransBankService;
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
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Microsoft\Graph\Generated\Models\BodyType;
use Microsoft\Graph\Generated\Models\EmailAddress;
use Microsoft\Graph\Generated\Models\ItemBody;
use Microsoft\Graph\Generated\Models\Message;
use Microsoft\Graph\Generated\Models\Recipient;
use Microsoft\Graph\Generated\Users\Item\SendMail\SendMailPostRequestBody;
use Microsoft\Graph\Graph;
use Microsoft\Graph\GraphServiceClient;
use Microsoft\Kiota\Abstractions\ApiException;
use Microsoft\Kiota\Authentication\Oauth\AuthorizationCodeContext;
use Microsoft\Kiota\Authentication\Oauth\ClientCredentialContext;

class RegisterMark extends Hookable
{
    public function register()
    {

        Ajax::listen('test', function () {
            global $wpdb;
            extract($_POST);
            extract($_GET);
            $response = new stdClass();
            $registration = DB::table('registration')
            ->where('id', 84)
            ->first();
            
            $general_info = get_field('mail_info', 'option');
            
            $data_email = [
                'mark_denomination' => $registration->mark_denomination,
                'mark_services' => json_decode($registration->mark_services),
                'mark_total_price' => $registration->mark_total_price,
                'whatsapp' => isset($general_info['whastapp']) && !empty($general_info['whastapp']) ? $general_info['whastapp'] : '',
                'rrss_mail' => isset($general_info['rrss_mail']) ? $general_info['rrss_mail'] : []

            ];

            try {
                //code...
                $emails_fm = get_field('emails', 'option');
                $emails_bcc = (new Post())->getTextArray($emails_fm['emails_bcc'], 'email');

                    Mail::to($registration->email)->bcc($emails_bcc)->send(new FlowCompletedMail('Registro completado ', $data_email));
                    

            } catch (\Exception $e) {
                Log::info( 'No se logró enviar el correo');
                Log::error($e);
            }

            // $link = env('LINK_CART') . '?id=' . $registration->mark_id . '&email=' . $registration->email . '&step=' . $registration->step;
            // Log::info($registration->id);
            // DB::table('registration')->where('mark_id', $registration->mark_id)->update(['reminder_done' => true]);
            // // Enviar un correo electrónico al usuario
            // $general_info = get_field('mail_info', 'option');
            // $data = [
            //     'link' => $link,
            //     'whatsapp' => isset($general_info['whastapp']) && !empty($general_info['whastapp']) ? $general_info['whastapp'] : ''
            // ];

            // try {
            //     //code...
            //     $emails_fm = get_field('emails', 'option');
            //     $emails_cc = (new Post())->getTextArray($emails_fm['emails_cc'], 'email');
            //     $emails_bcc = (new Post())->getTextArray($emails_fm['emails_bcc'], 'email');

            //         Mail::to($registration->email)->bcc($emails_bcc)->send(new ForgottenCartMail('Olvidaste terminar tu registro ', $data));

            // } catch (\Exception $e) {
            //     Log::info( 'No se logró enviar el correo');
            //     Log::error($e);
            // }

            die();
        });

        Ajax::listen('trademark-logo', function () {
            global $wpdb;
            extract($_POST);
            extract($_GET);
            $response = new stdClass();

            $validator = Validator::make(Request::all(), [
                'file' => 'mimes:png,jpeg,jpg,svg',
            ], [
                'files.mimes' => __('El formato del archivo no es válido.', 'meat'),
            ]);

            if ($validator->fails()) {
                $response->message = new stdClass();
                $response->message->text = __('Faltan campos requeridos', 'meat');
                $response->success = false;
                $response->message->extra_info = implode('<br>', $validator->messages()->all());
                wp_send_json($response, 200);
                die();
            }

            if (Request::hasFile('file')) {
                $file = Request::file('file');
                $name = sanitize_title($file->getClientOriginalName()) . '_' . strtotime("now");
                $extension = $file->getClientOriginalExtension();
                $new_name = $name . '.' . $extension;
                try {
                    $filepath = $file->storeAs('logos', $new_name, 'public');
                    $file_url = Storage::disk('public')->url($filepath);
                    $filepath = Storage::disk('public')->path($filepath);
                } catch (\Exception $e) {
                    $response->title = __('Error Archivo', 'imagina');
                    $response->message = __('Ha ocurrido un error al intentar guardar el archivo', 'imagina');
                    wp_send_json($response, 200);
                    die();
                }
            }

            $response = [
                'status' => 200,
                'success' => true,
                'stored_image_url' => $file_url ?? ''
            ];
            wp_send_json($response);
            die();
        });

        Ajax::listen('step-1', function () {
            global $wpdb;
            extract($_POST);
            extract($_GET);
            $response = new stdClass();

            $table = 'registration';

            $validator = Validator::make(Request::all(), [
                'email' => 'required|email',
                'type' => 'required',
            ], [
                'email.required'    => __('El correo electrónico es requerido.', 'meat'),
                'type.required'    => __('El tipo de marca es requerido.', 'meat'),
            ]);

            if ($validator->fails()) {
                $response->message = new stdClass();
                $response->message->text = __('Faltan campos requeridos', 'meat');
                $response->success = false;
                $response->message->extra_info = implode('<br>', $validator->messages()->all());
                wp_send_json($response, 200);
                die();
            }

            try {

                // Creamos un cliente Guzzle
                $client = new Client();
                // Realizamos la petición POST
                $response = $client->post(env('REGISTRATION_URL_API') . "/marcas/categorias", [
                    "json" => [
                        "email" => Request::get('email'),
                        "telefono" => Request::get('telefono'),
                    ]
                ]);


                // Verificamos el estado de la respuesta
                if ($response->getStatusCode() == 200) {
                    // La petición se ha realizado correctamente
                    $body = $response->getBody()->getContents();
                    $body = json_decode($body);

                    DB::table($table)->insertGetId([
                        'step' => 'step-1', 'mark_id' => $body->id, 'mark_denomination' => Request::get('trademark_name') ?? '', 'mark_type' => Request::get('type'), 'email' => Request::get('email'), 'telefono' => Request::get('telefono'), 'mark_image' => Request::get('stored_filename') ?? '',
                        'local_storage' => json_encode(Request::get('local_storage')),
                        'created_at' => date('Y-m-d H:i:s'),
                        'image_extra_info' => Request::get('image_extra_info') ?? '',
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    $id = $body->id;
                    $categories = [];

                    if (isset($body->categorias) && !empty($body->categorias)) {
                        $colors = ['#B8E5B8', '#98E4E4', '#CCCCFF', '#FFCCCC', '#EAEA83','#B8E5B8', '#98E4E4', '#CCCCFF', '#FFCCCC', '#EAEA83','#B8E5B8', '#98E4E4', '#CCCCFF', '#FFCCCC', '#EAEA83','#B8E5B8', '#98E4E4', '#CCCCFF', '#FFCCCC', '#EAEA83','#B8E5B8', '#98E4E4', '#CCCCFF', '#FFCCCC', '#EAEA83'];
                        $icons = [
                            themosis_assets() . '/images/icons/white_mug.svg',
                            themosis_assets() . '/images/icons/white_heart_handshake.svg',
                            themosis_assets() . '/images/icons/white_building_store.svg',
                            themosis_assets() . '/images/icons/white_chef_hat.svg',
                            themosis_assets() . '/images/icons/white_user_star.svg',
                            themosis_assets() . '/images/icons/white_mug.svg',
                            themosis_assets() . '/images/icons/white_heart_handshake.svg',
                            themosis_assets() . '/images/icons/white_building_store.svg',
                            themosis_assets() . '/images/icons/white_chef_hat.svg',
                            themosis_assets() . '/images/icons/white_user_star.svg',
                            themosis_assets() . '/images/icons/white_mug.svg',
                            themosis_assets() . '/images/icons/white_heart_handshake.svg',
                            themosis_assets() . '/images/icons/white_building_store.svg',
                            themosis_assets() . '/images/icons/white_chef_hat.svg',
                            themosis_assets() . '/images/icons/white_user_star.svg',
                            themosis_assets() . '/images/icons/white_mug.svg',
                            themosis_assets() . '/images/icons/white_heart_handshake.svg',
                            themosis_assets() . '/images/icons/white_building_store.svg',
                            themosis_assets() . '/images/icons/white_chef_hat.svg',
                            themosis_assets() . '/images/icons/white_user_star.svg'
                        ];
                        foreach ($body->categorias as $key => $category) {
                            $categories[] =  [
                                'color' => isset($category->Color) && !empty($category->Color) ? $category->Color : $colors[$key],
                                'icon' => [
                                    'url' => isset($category->Icono) && !empty($category->Icono) ? $category->Icono : $icons[$key],
                                    'alt' => 'Icono de taza'
                                ],
                                'title' => $category->Categoria,
                                'key' => $category->Categoria,
                                'key_id' => $category->CategoriaID,
                                'description' => '<p>' . $category->Descripcion . '</p>
                                '
                            ];
                        }
                    }

                    $response = [
                        'status' => 200,
                        'success' => true,
                        'email' => Request::get('email'),
                        'categories' => $categories,
                        'id' => $id
                    ];
                    wp_send_json($response);
                    die();
                } else {
                    // La petición ha fallado
                }
            } catch (\Throwable $th) {
                //throw $th;
                dd($th);
            }
        });

        Ajax::listen('step-2', function () {
            global $wpdb;
            extract($_POST);
            extract($_GET);
            $response = new stdClass();

            $table = 'registration';

            $validator = Validator::make(Request::all(), [
                'email' => 'required|email',
                'checked_categories' => 'required',
            ], [
                'email.required'    => __('El correo electrónico es requerido.', 'meat'),
                'checked_categories.required'    => __('Al menos una categoría es requerida.', 'meat'),
            ]);


            if ($validator->fails()) {
                $response->message = new stdClass();
                $response->message->text = __('Faltan campos requeridos', 'meat');
                $response->success = false;
                $response->message->extra_info = implode('<br>', $validator->messages()->all());
                wp_send_json($response, 200);
                die();
            }

            $registration = DB::table('registration')
                ->where('mark_id', Request::get('id'))
                ->where('email', Request::get('email'))
                ->first();

            if (!empty($registration)) {

                $categories = implode(';', Request::get('checked_categories'));
                DB::table('registration')->where('mark_id', Request::get('id'))->where('email', Request::get('email'))->update([
                    'mark_category' => $categories, 'step' => 'step-2',
                    'local_storage' => json_encode(Request::get('local_storage')),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                $response = [
                    'status' => 200,
                    'success' => true,
                    'id' => $registration->mark_id,
                    'email' => $registration->email,
                ];
            }

            wp_send_json($response);
            die();
        });

        Ajax::listen('subcategories', function () {
            global $wpdb;
            extract($_POST);
            extract($_GET);
            $response = new stdClass();

            // $validator = Validator::make(Request::all(), [
            //     'id' => 'required',
            //     'email' => 'required|email',
            // ], [
            //     'email.required'    => __('El correo electrónico es requerido.', 'meat'),
            //     'id.required'    => __('El id es requerido.', 'meat'),
            // ]);

            // if ($validator->fails()) {
            //     $response->message = new stdClass();
            //     $response->message->text = __('Faltan campos requeridos', 'meat');
            $response->success = false;
            //     $response->message->extra_info = implode('<br>', $validator->messages()->all());
            //     wp_send_json($response, 200);
            //     die();
            // }

            try {
                $registration = DB::table('registration')
                    ->where('mark_id', Request::get('id'))
                    ->where('email', Request::get('email'))
                    ->first();

                if (!empty($registration)) {


                    $categories = explode(';', $registration->mark_category);
                    $categories_array = [];
                    if (!empty($categories)) {
                        foreach ($categories as $category) {
                            $cat = new stdClass();
                            // Creamos un cliente Guzzle
                            $client = new Client();
                            // Realizamos la petición POST
                            $mark = new stdClass();
                            $mark->denominacion =  $registration->mark_denomination;
                            $mark->tipo =  $registration->mark_type;
                            $mark->categoria =  $category;
                            $mark->cobertura =  '';
                            $data = [
                                "id" => $registration->mark_id,
                                "email" => $registration->email,
                                "telefono" => $registration->telefono,
                                "marca" => $mark,
                            ];

                            $response = $client->post(env('REGISTRATION_URL_API') . "/marcas/cobertura", [
                                "json" => $data
                            ]);


                            // Verificamos el estado de la respuesta
                            if ($response->getStatusCode() == 200) {

                                $cat->category_label = $category;
                                $cat->category_key = $category;
                                // $cat->pagination = [
                                //     'page' => 1,
                                //     'next_page' => 0,
                                //     'prev_page' => 0,
                                //     'max_page' => 1,
                                //     'per_page' => 12,
                                //     'total_items' => 6,
                                // ];
                                $cat->subcategories = [];
                                // La petición se ha realizado correctamente
                                $body = $response->getBody()->getContents();
                                $body = json_decode($body);

                                if (!empty($body->coberturas)) {
                                    foreach ($body->coberturas as $key => $item) {
                                        $subcat = new stdClass();
                                        $subcat->title = $item->categoriaSub;
                                        $subcat->key = $item->clase . '-' . $key . '-' . $category;
                                        $subcat->class = $item->clase;
                                        $subcat->description = $item->descripcion;
                                        $cat->subcategories[] = $subcat;
                                    }

                                    $categories_array[] = $cat;
                                }
                            } else {
                                // La petición ha fallado
                            }
                        }
                        $response = [
                            'status' => 200,
                            'success' => true,
                            'id' => $body->id,
                            'email' => $registration->email,
                            'subcategories' => $categories_array,
                        ];
                        wp_send_json($response);
                        die();
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
                dd($th);
            }

            die();
        });

        Ajax::listen('subcategories-from', function () {
            global $wpdb;
            extract($_POST);
            extract($_GET);
            $response = new stdClass();

            $validator = Validator::make(Request::all(), [
                'id' => 'required',
                'category' => 'required',
                'email' => 'required|email',
            ], [
                'email.required'    => __('El correo electrónico es requerido.', 'meat'),
                'category.required'    => __('La categoría es requerida.', 'meat'),
                'id.required'    => __('El id es requerido.', 'meat'),
            ]);

            if ($validator->fails()) {
                $response->message = new stdClass();
                $response->message->text = __('Faltan campos requeridos', 'meat');
                $response->success = false;
                $response->message->extra_info = implode('<br>', $validator->messages()->all());
                wp_send_json($response, 200);
                die();
            }

            try {
                $registration = DB::table('registration')
                    ->where('mark_id', Request::get('id'))
                    ->where('email', Request::get('email'))
                    ->first();

                if (!empty($registration)) {

                    $categories_array = [];
                    $cat = new stdClass();
                    // Creamos un cliente Guzzle
                    $client = new Client();
                    // Realizamos la petición POST
                    $mark = new stdClass();
                    $mark->denominacion =  $registration->mark_denomination;
                    $mark->tipo =  $registration->mark_type;
                    $mark->categoria =  $category;
                    $mark->cobertura =  Request::get('search') ?? '';
                    $data = [
                        "id" => $registration->mark_id,
                        "email" => $registration->email,
                        "telefono" => $registration->telefono,
                        "marca" => $mark,
                    ];

                    $response = $client->post(env('REGISTRATION_URL_API') . "/marcas/cobertura", [
                        "json" => $data
                    ]);


                    // Verificamos el estado de la respuesta
                    if ($response->getStatusCode() == 200) {


                        // La petición se ha realizado correctamente
                        $body = $response->getBody()->getContents();
                        $body = json_decode($body);

                        if (!empty($body->coberturas)) {
                            foreach ($body->coberturas as $key => $item) {


                                $subcat = [
                                    'title' => $item->categoriaSub,
                                    'key' => $item->clase . '-' . $key . '-' . $category,
                                    'class' => $item->clase,
                                    'description' => $item->descripcion
                                ];
                                $categories_array[] = $subcat;
                            }
                        }

                        $response = [
                            'status' => 200,
                            'id' => $body->id,
                            'email' => Request::get('email'),
                            'subcategories' => array_values($categories_array),
                            'category_label' => $category,
                            'category_key' => $category,
                        ];
                        wp_send_json($response);
                        die();
                    } else {
                        // La petición ha fallado
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
                dd($th);
            }

            die();
        });

        Ajax::listen('step-3', function () {
            global $wpdb;
            extract($_POST);
            extract($_GET);
            $response = new stdClass();

            $validator = Validator::make(Request::all(), [
                'id' => 'required',
                'checked_subcategories' => 'required',
                'email' => 'required|email',
            ], [
                'email.required'    => __('El correo electrónico es requerido.', 'meat'),
                'id.required'    => __('El id es requerido.', 'meat'),
                'checked_subcategories.required'    => __('Es necesaria una subcategoría como mínimo.', 'meat'),
            ]);

            if ($validator->fails()) {
                $response->message = new stdClass();
                $response->message->text = __('Faltan campos requeridos', 'meat');
                $response->success = false;
                $response->message->extra_info = implode('<br>', $validator->messages()->all());
                wp_send_json($response, 200);
                die();
            }

            try {

                $registration = DB::table('registration')
                    ->where('mark_id', Request::get('id'))
                    ->where('email', Request::get('email'))
                    ->first();

                if (!empty($registration)) {

                    $coverages = Request::get('checked_subcategories');
                    
                    if (!empty($coverages)) {
                        $new_array = [];
                        foreach ($coverages as $item) {
                            $clase = explode('-', $item["key"])[0];

                            // Obtener la cobertura del elemento actual
                            $cobertura = $item["title"];

                            // Si la clase del elemento actual no existe en el nuevo array
                            if (!array_key_exists($clase, $new_array)) {

                                // Agregar la clase al nuevo array
                                $new_array[$clase] = [];
                                $new_array[$clase]['clase'] = $clase;
                                $new_array[$clase]['cobertura'] = '';
                            }

                            // Agregar la cobertura al nuevo array
                            $new_array[$clase]['cobertura'] = empty($new_array[$clase]['cobertura']) ? $cobertura : $new_array[$clase]['cobertura'] . ';' . $cobertura;
                        }
                        $new_array = array_values($new_array);
                    }
                    $categories = !empty(Request::get('checked_categories')) ? implode(';', Request::get('checked_categories')) : [];
                    $new_array = json_encode($new_array);
                    DB::table('registration')->where('mark_id', Request::get('id'))->update([
                        'mark_category' => !empty($categories) ? $categories : $registration->mark_category,
                        'mark_class_text' => Request::get('mark_class_text') ?? '',
                        'mark_classes' => $new_array,
                        'mark_image' => Request::get('stored_filename') ?? $registration->mark_image,
                        'mark_denomination' => Request::get('trademark_name') ?? $registration->mark_denomination,
                        'email' => Request::get('email') ?? $registration->email,
                        'mark_type' => Request::get('type') ?? $registration->mark_type,
                        'step' => 'step-3',
                        'local_storage' => json_encode(Request::get('local_storage')),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                    $response = ApiClientService::getSimilarities($registration->mark_id, $registration->email);
                    $response['status'] = 200;
                    $response['success'] = true;

                    wp_send_json($response);
                }
            } catch (\Throwable $th) {
                //throw $th;
                dd($th);
            }

            die();
        });

        Ajax::listen('step-4', function () {
            global $wpdb;
            extract($_POST);
            extract($_GET);
            $response = new stdClass();

            $validator = Validator::make(Request::all(), [
                'id' => 'required',
                // 'selected_classes' => 'required',
                'selected_services' => 'required',
                'email' => 'required|email',
            ], [
                'email.required'    => __('El correo electrónico es requerido.', 'meat'),
                'id.required'    => __('El id es requerido.', 'meat'),
                'selected_classes.required'    => __('Es necesaria una clase como mínimo.', 'meat'),
                'selected_services.required'    => __('Los servicios son requeridos.', 'meat'),
            ]);

            if ($validator->fails()) {
                $response->message = new stdClass();
                $response->message->text = __('Faltan campos requeridos', 'meat');
                $response->success = false;
                $response->message->extra_info = implode('<br>', $validator->messages()->all());
                wp_send_json($response, 200);
                die();
            }

            try {

                $registration = DB::table('registration')
                    ->where('mark_id', Request::get('id'))
                    ->where('email', Request::get('email'))
                    ->first();

                $new_array = [];
                if (!empty($registration)) {

                    $classes = Request::get('selected_classes');

                    if (!empty($classes)) {
                        foreach ($classes as $item) {
                            
                            $clase = $item["key"];
                            $cobertura = $item["title"];

                            $new_array[$clase] = [];
                            $new_array[$clase]['clase'] = $clase;
                            $new_array[$clase]['cobertura'] = $cobertura;

                        }
                        $new_array = array_values($new_array);
                    }
                    $new_array = !empty($new_array) ? json_encode($new_array) : $registration->mark_classes;
                    
                    $selected_services = Request::get('selected_services');

                    if(!empty($selected_services)){
                        foreach ($selected_services as $key => $item) {
                            $selected_services[$key]['price'] = str_replace(['$','.','%'],'',$item['price']);
                            $selected_services[$key]['price_iva'] = str_replace(['$','.','%'],'',$item['price_iva']);
                            $selected_services[$key]['net_price'] = str_replace(['$','.','%'],'',$item['net_price']);
                            $selected_services[$key]['discount_perc'] = str_replace(['$','.','%'],'',$item['discount_perc']);
                            $selected_services[$key]['discount_value'] = str_replace(['$','.','%'],'',$item['discount_value']);
                        }
                    }

                    DB::table('registration')->where('mark_id', Request::get('id'))->update([
                        'mark_classes' => $new_array,
                        'mark_services' => json_encode($selected_services),
                        'mark_image' => Request::get('stored_filename') ?? $registration->mark_image,
                        'mark_denomination' => Request::get('trademark_name') ?? $registration->mark_denomination,
                        'email' => Request::get('email') ?? $registration->email,
                        'mark_type' => Request::get('type') ?? $registration->mark_type,
                        'step' => 'step-4',
                        'local_storage' => json_encode(Request::get('local_storage')),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                    $cupon_de_descuento = Request::get('cupon_de_descuento') ?? '';

                    $response = ApiClientService::getSimilarities($registration->mark_id, $registration->email, $cupon_de_descuento);
                    $response['status'] = 200;
                    $response['success'] = true;
                    wp_send_json($response);
                }
            } catch (\Throwable $th) {
                //throw $th;
                dd($th);
            }

            die();
        });

        Ajax::listen('step-5', function () {
            global $wpdb;
            extract($_POST);
            extract($_GET);
            $response = new stdClass();

            $validator = Validator::make(Request::all(), [
                'id' => 'required',
                'address' => 'required',
                'region' => 'required',
                'comuna' => 'required',
                'phone' => 'required',
                'type' => 'required',
                'email' => 'required|email',
            ], [
                'email.required'    => __('El correo electrónico es requerido.', 'meat'),
                'id.required'    => __('El id es requerido.', 'meat'),
            ]);

            if ($validator->fails()) {
                $response->message = new stdClass();
                $response->message->text = __('Faltan campos requeridos', 'meat');
                $response->success = false;
                $response->message->extra_info = implode('<br>', $validator->messages()->all());
                wp_send_json($response, 200);
                die();
            }

            try {

                $registration = DB::table('registration')
                    ->where('mark_id', Request::get('id'))
                    ->where('email', Request::get('email'))
                    ->first();
                if (!empty($registration)) {
                    $holders[] = [
                        'id' => 1,
                        'titular' => Request::get('type') == 'persona-natural' ? 'Persona' : 'Empresa',
                        'nombre' =>  Request::get('type') == 'persona-natural' ? Request::get('firstName') : Request::get('company_name'),
                        'apellido' =>  Request::get('type') == 'persona-natural' ? Request::get('lastname') : '',
                        'email' =>  Request::get('email_owner'),
                        'rut' =>  Request::get('type') == 'persona-natural' ? Request::get('rut') : Request::get('company_rut'),
                        'direccion' =>  Request::get('address'),
                        'region' =>  Request::get('region'),
                        'comuna' =>  Request::get('comuna'),
                        'telefono' =>  Request::get('phone'),
                        'giro' =>  Request::get('type') == 'persona-natural' ? '' : Request::get('company_giro'),
                    ];

                    $other_owners = Request::get('other_owners');
                    if (!empty($other_owners)) {
                        foreach ($other_owners as $key => $item) {
                            $holders[] = [
                                'id' => $key + 2,
                                'titular' => 'Persona',
                                'nombre' =>  $item['name'],
                                'apellido' => '',
                                'email' =>  $item['email'],
                                'rut' =>  $item['rut'],
                                'direccion' =>  Request::get('address'),
                                'region' =>  Request::get('region'),
                                'comuna' =>  Request::get('comuna'),
                                'telefono' =>  Request::get('phone'),
                                'giro' =>  ''
                            ];
                        }
                    }
                    $amount = (float) $registration->mark_total_price;
                    //if (Request::get('payment_method') == 'webpay'){}
                    $tbk_response = TransBankService::createTransaction($amount, $registration->id);
                    try {
                        Log::info('token_tbk: ' . $tbk_response['token_tbk']);
                        DB::table('registration')->where('mark_id', Request::get('id'))->update([
                            'token_tbk' => $tbk_response['token_tbk'],
                            'mark_holders' => json_encode($holders),
                            'payment_method' => Request::get('payment_method'),
                            'date_finish' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    } catch (\Throwable $th) {
                        Log::error($th->getMessage());
                    }
                    // TransBankService::statusTransaction('01abb45f04e7aed96699d23210a16a722ff0ece5920f1decbf501ccf58a81bc2');
                    $response = [
                        'status' => 200,
                        'success' => true,
                        'redirect' => $tbk_response['url'],
                    ];
                    wp_send_json($response);
                    die();
                }
            } catch (\Throwable $th) {
                //throw $th;
                dd($th);
            }
        });

        Ajax::listen('get-steps', function () {
            global $wpdb;
            extract($_POST);
            extract($_GET);
            $response = new stdClass();

            $validator = Validator::make(Request::all(), [
                'id' => 'required',
                'email' => 'required|email',
            ], [
                'email.required'    => __('El correo electrónico es requerido.', 'meat'),
                'id.required'    => __('El id es requerido.', 'meat'),
            ]);

            if ($validator->fails()) {
                $response->message = new stdClass();
                $response->message->text = __('Faltan campos requeridos', 'meat');
                $response->success = false;
                $response->message->extra_info = implode('<br>', $validator->messages()->all());
                wp_send_json($response, 200);
                die();
            }

            try {

                $registration = DB::table('registration')
                    ->where('mark_id', Request::get('id'))
                    ->where('email', Request::get('email'))
                    ->first();
                if (!empty($registration)) {

                    // TransBankService::statusTransaction('01abb45f04e7aed96699d23210a16a722ff0ece5920f1decbf501ccf58a81bc2');

                    //order_data
                    $selected_services = [];
                    if (property_exists($registration, 'mark_services') && !empty($registration->mark_services)) {
                        foreach (json_decode($registration->mark_services) as $key => $value) {
                            $selected_services[] = [
                                'title' =>  $value->title,
                                'key' => $value->key,
                                'id' => $value->id,
                                'group' => $value->group,
                                'optional' => $value->optional,
                                'price' => '$' . number_format((int)$value->price, 0, '', '.'),
                                'price_iva' => '$' . number_format((int)$value->price_iva, 0, '', '.'),
                                'net_price' => '$' . number_format((int)$value->net_price, 0, '', '.'),
                                'discount_perc' => str_replace(['%','-'],'',$value->discount_perc),
                                'discount_value' => '$' . number_format((int)$value->discount_value, 0, '', '.'),
                            ];
                        }
                    }

                    $level = "";
                    switch ($registration->mark_status) {
                        case "Disponible":
                            $level = "low";
                            break;
                        case "Precaución":
                            $level = "warning";
                            break;
                        case "Alto riesgo":
                            $level = "high";
                            break;
                    }

                    $class_array = [];
                    if (property_exists($registration, 'mark_classes')  && !empty($registration->mark_classes)) {
                        $classes = json_decode($registration->mark_classes);
                        foreach ($classes as $key => $value) {
                            $class_array[] = [
                                'description' => '',
                                'key' => $value->clase,
                                'title' => $value->cobertura
                            ];
                        }
                    }

                    $summary = [
                        'details_modal' => [
                            'title' => 'Título',
                            'content' => '
                          <p>Helicopter best nail optimize effects. Own optimize look open scope closing hop great of. Dive this engagement about and first. Staircase social like weeks managing revision quarter underlying invite break. Seems panel yet production encourage model marginalised can.</p>
                        '
                        ],
                        'services' => json_decode($registration->mark_services),
                        'total' => '$' . (!is_null($registration->mark_total_price) ? number_format($registration->mark_total_price, 0, '', '.') : 0)
                    ];

                    $disclaimer = get_field('register_disclaimer', 'option') ?? '';

                    $order_data = [
                        'available_domain' => isset($body->dominio_estado) && $body->dominio_estado == 'Disponible',
                        'disclaimer' => $disclaimer,
                        'risk' => [
                            'description' => $registration->mark_message,
                            'level' => $level,
                            'title' => $registration->mark_status,
                        ],
                        'selected_classes' => $class_array, // cambiar a description key title
                        'selected_services' => $selected_services, // cambiar a key title
                        'suggested_domain' => $registration->mark_domain, // cambiar a key title
                        'summary' => $summary
                    ];
                    $response = [
                        'status' => 200,
                        'success' => true,
                        'steps' => json_decode($registration->local_storage),
                        'order_data' => $order_data
                    ];
                    wp_send_json($response);
                    die();
                }
            } catch (\Throwable $th) {
                //throw $th;
                dd($th);
            }
        });
    }
}
