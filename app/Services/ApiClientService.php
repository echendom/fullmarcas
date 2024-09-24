<?php

/**
 * User: Jesús Ruíz
 * Date: 11-01-24
 */

namespace App\Services;

use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use stdClass;

class ApiClientService
{
    public static function getSimilarities($mark_id, $email, $cupon_de_descuento = null)
    {

        $registration = DB::table('registration')
            ->where('mark_id', $mark_id)
            ->first();

        if (!empty($registration)) {


            $classes = $registration->mark_classes;
            $classes = !empty($classes) ? json_decode($classes) : [];
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
            

            $data = [
                "id" => $mark_id,
                "email" => $email,
                "telefono" => $registration->telefono,
                "marca" => $mark,
                "cupon_de_descuento" => $cupon_de_descuento
            ];

            $response = $client->post(env('REGISTRATION_URL_API') . "/marcas/similitud", [
                "json" => $data
            ]);


            // Verificamos el estado de la respuesta
            if ($response->getStatusCode() == 200) {
                // La petición se ha realizado correctamente
                $body = $response->getBody()->getContents();
                $body = json_decode($body);
                $domain_status = ($body->dominio_estado);
                
                $services = $registration->mark_services != '[]' ? json_decode($registration->mark_services) : [];
                $services_show = [];
                $services_response = [];
                $total_response = 0;
                $total = 0;
                $total_bill = 0;
                if(isset($body->servicios) && !empty($body->servicios)){
                    foreach ($body->servicios as $key => $item) {
                        $total_response += $item->valorTotal;
                        $services_response[] = [
                            'title' =>  $item->resumen,
                            'key' => $item->servicio,
                            'id' => $item->id,
                            'on_bill' => $item->incluirEnFactura,
                            'group' => $item->grupo,
                            'optional' => property_exists($item,'opcional') ? $item->opcional : false,
                            'price' => '$' . number_format((int)$item->valorTotal, 0, '', '.'),
                            'price_iva' => '$' . number_format((int)$item->valorIva, 0, '', '.'),
                            'net_price' => '$' . number_format((int)$item->valorNeto, 0, '', '.'),
                            'discount_perc' => str_replace(['%','-'],'',$item->valorDescuentoPorcentaje),
                            'discount_value' => '$' . number_format(str_replace('-','',$item->valorDescuento), 0, '', '.'),
                          ];
                       
                    }
                }
                if(isset($body->servicios) && !empty($body->servicios) && empty($services)){
                    foreach ($body->servicios as $key => $item) {
                       
                        if($item->incluirEnFactura == 'true'){
                            $total_bill += $item->valorTotal;
                        }
                        $total += $item->valorTotal;

                        $service = [
                            'title' =>  $item->resumen,
                            'key' => $item->servicio,
                            'id' => $item->id,
                            'group' => $item->grupo,
                            'optional' => property_exists($item,'opcional') ? $item->opcional : false,
                            'on_bill' => $item->incluirEnFactura,
                            'price' => $item->valorTotal,
                            'price_iva' => $item->valorIva,
                            'net_price' => $item->valorNeto,
                            'discount_perc' => $item->valorDescuentoPorcentaje,
                            'discount_value' => $item->valorDescuento,
                          ];
                          $services[] = $service;
                          $service['price'] = '$' . number_format((int)$item->valorTotal, 0, '', '.');
                          $service['price_iva'] = '$' . number_format((int)$item->valorIva, 0, '', '.');
                          $service['net_price'] = '$' . number_format((int)$item->valorNeto, 0, '', '.');
                          $service['discount_perc'] = str_replace(['%','-'],'',$item->valorDescuentoPorcentaje);
                          $service['discount_value'] = '$' . number_format(str_replace('-','',$item->valorDescuento), 0, '', '.');
                          $services_show[] = $service;
                        
                    }
                }else {
                        foreach ($services as $key => $value) {
                                $total += (int)$value->price;
                            if(property_exists($value,'on_bill') && $value->on_bill){
                                $total_bill += $value->price;
                            }

                            
                            $services_show[] = [
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
                            ];                        }
                }
                $similarity = [];

                if(!empty($body->similitudes)){
                    foreach ($body->similitudes as $key => $item) {
                        $similarity[] = [
                            'id' => $item->id,
                            'denomination' => $item->denominacion,
                            'request' => $item->solicitud,
                            'classes' => $item->clases,
                        ];
                    }
                }
                DB::table('registration')->where('mark_id', $mark_id)->update(
                    [
                        'mark_similarity' => json_encode($similarity),
                        'mark_denomination' => $body->marca,
                        'mark_status' => $body->marca_estado,
                        'mark_message' => $body->marca_mensaje,
                        'mark_domain_status' => $domain_status,
                        'mark_services' => json_encode($services),
                        'mark_domain' => $body->dominio ?? 'No disponible',
                        'mark_domain_message' => $body->dominio_mensaje,
                        'mark_total_price' => $total,
                        'mark_total_bill_price' => $total_bill,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]
                );

                $summary = [
                    'details_modal' => [
                        'title' => 'Título',
                        'content' => '
                          <p>Helicopter best nail optimize effects. Own optimize look open scope closing hop great of. Dive this engagement about and first. Staircase social like weeks managing revision quarter underlying invite break. Seems panel yet production encourage model marginalised can.</p>
                        '
                    ],
                    'services' => $services_show,
                    'total' => '$' . number_format($total, 0, '', '.')
                ];

                $class_array = [];
                if (property_exists($registration, 'mark_classes')){
                    $classes = json_decode($registration->mark_classes);
                    foreach ($classes as $key => $value) {
                        $class_array[] = [
                            'description' => '',
                            'key' => $value->clase,
                            'title' => $value->cobertura
                        ];
                    }
                }
                $level = "";
                switch ($body->marca_estado) {
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
                $registration = DB::table('registration')
                ->where('mark_id', $mark_id)
                ->first();
                $selected_services = [];
                if(property_exists($registration,'mark_services') && !empty($registration->mark_services)){
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

                $disclaimer = get_field('register_disclaimer','option') ?? '';
                $response = [
                    'available_domain' => isset($body->dominio_estado) && $body->dominio_estado == 'Disponible',
                    'disclaimer' => $disclaimer,
                  'risk' => [
                    'description' => $body->marca_mensaje,
                    'level' => $level,
                    'title' => $body->marca_estado,
                  ],
                  'selected_classes' => $class_array, // cambiar a description key title
                  'selected_services' => $selected_services, // cambiar a key title
                  'services_response' => $services_response, // cambiar a key title
                  'suggested_domain' => $body->dominio, // cambiar a key title
                  'summary' => $summary,
                  'similarity' => $similarity,
                  'total' => '$' . number_format($total, 0, '', '.'),
                  'total_response' => '$' . number_format($total_response, 0, '', '.'),
                  'cupon_de_descuento' => $body->cupon_de_descuento ?? '',
                  'cupon_de_descuento_estado' => $body->cupon_de_descuento_estado ?? '',
                  'cupon_de_descuento_mensaje' => $body->cupon_de_descuento_mensaje ?? ''
                ];
                return $response;
            }
        }
    }

    public static function getSerial($original, $id) {
        // Convertir $id a cadena
        $idStr = strval($id);
      
        // Longitud de la cadena $original
        $originalLen = strlen($original);
      
        // Si $id es más largo que $original, se devuelve $id
        if (strlen($idStr) > $aLen) {
          return $idStr;
        }
      
        // Recortar $id si es más corto que $a
        if (strlen($idStr) < $aLen) {
          $idStr = str_pad($idStr, $aLen, "0", STR_PAD_RIGHT);
        }
      
        // Reemplazar ceros de derecha a izquierda
        return substr_replace($a, $idStr, -strlen($idStr), strlen($idStr));
      }
}
