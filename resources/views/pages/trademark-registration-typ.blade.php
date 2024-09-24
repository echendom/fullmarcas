@extends('layouts.default')
@php
    $typ_fields = get_field('typ_register', 'option') ?? []
@endphp
@section('content')
  @include('components.general-typ', [
    'clear_storage' => true,
    'pretitle' => isset($typ_fields['pretitle']) && !empty($typ_fields['pretitle']) ? $typ_fields['pretitle'] : '',
    'icon' => isset($typ_fields['icon']) && !empty($typ_fields['icon']) ? $typ_fields['icon'] : [],
    'title' => isset($typ_fields['title']) && !empty($typ_fields['title']) ? $typ_fields['title'] : '',
    'subtitle' => isset($typ_fields['subtitle']) && !empty($typ_fields['subtitle']) ? $typ_fields['subtitle'] : '',
    'description' => isset($typ_fields['description']) && !empty($typ_fields['description']) ? $typ_fields['description'] : '',
    'order_details' => [
      'title' => isset($typ_fields['other_title']) && !empty($typ_fields['other_title']) ? $typ_fields['other_title'] : '',
      'trademark_name' => $fields['trademark_name'] ?? 'Nombre de la marca',
      'summary' => $fields['summary'] ?? [
        'services' => [
          [
            'title' => 'Nombre del servicio',
            'key' => 'service-1',
            'details' => [
              [
                'title' => 'Detalle del servicio',
                'key' => 'service-1-detail-1',
                'price' => '$000.000'
              ],
              [
                'title' => 'Detalle del servicio',
                'key' => 'service-1-detail-2',
                'price' => '$000.000'
              ]
            ]
          ],
          [
            'title' => 'Nombre del servicio',
            'key' => 'service-2',
            'details' => [
              [
                'title' => 'Detalle del servicio',
                'key' => 'service-2-detail-1',
                'price' => '$000.000'
              ],
              [
                'title' => 'Detalle del servicio',
                'key' => 'service-2-detail-2',
                'price' => '$000.000'
              ]
            ]
          ],
          [
            'title' => 'Nombre del servicio',
            'key' => 'service-3',
            'details' => [
              [
                'title' => 'Detalle del servicio',
                'key' => 'service-3-detail-1',
                'price' => '$000.000'
              ],
              [
                'title' => 'Detalle del servicio',
                'key' => 'service-3-detail-2',
                'price' => '$000.000'
              ]
            ]
          ]
        ],
        'total' => '$000.000',
        'details_modal' => isset($typ_fields['details_modal']) && !empty($typ_fields['details_modal']) ? $typ_fields['details_modal'] :[
          'title' => 'Título',
          'content' => '
            <p>Helicopter best nail optimize effects. Own optimize look open scope closing hop great of. Dive this engagement about and first. Staircase social like weeks managing revision quarter underlying invite break. Seems panel yet production encourage model marginalised can.</p>
          '
        ]
      ],
    ],
    'primary_button' => isset($typ_fields['primary_button']) && !empty($typ_fields['primary_button']) ? $typ_fields['primary_button'] : [],
    'secondary_button' => isset($typ_fields['secondary_button']) && !empty($typ_fields['secondary_button']) ? $typ_fields['secondary_button'] : [],
    'image' => isset($typ_fields['image']) && !empty($typ_fields['image']) ? $typ_fields['image'] : []
  ])
@endsection
