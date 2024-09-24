@extends('layouts.trademark-registration')
@php
    $fields = get_field('mark_register', 'option');
    $step_5_props = isset($fields['step_5_props']) && !empty($fields['step_5_props']) ? $fields['step_5_props'] : [];
    $step_5_props['regions'] = [
        [
            'region' => 'Antofagasta',
            'comunas' => ['Antofagasta', 'Calama', 'María Elena', 'Mejillones', 'Ollagüe', 'San Pedro de Atacama', 'Sierra Gorda', 'Taltal', 'Tocopilla'],
        ],
        [
            'region' => 'Atacama',
            'comunas' => ['Alto del Carmen', 'Caldera', 'Chañaral', 'Copiapó', 'Diego de Almagro', 'Freirina', 'Huasco', 'Tierra Amarilla', 'Vallenar'],
        ],
        [
            'region' => 'Arica y Parinacota',
            'comunas' => ['Arica', 'Camarones', 'General Lagos', 'Putre'],
        ],
        [
            'region' => 'Coquimbo',
            'comunas' => ['Andacollo', 'Canela', 'Combarbalá', 'Coquimbo', 'Illapel', 'La Serena', 'La Higuera', 'Los Vilos', 'Monte Patria', 'Ovalle', 'Paiguano', 'Punitaqui', 'Río Hurtado', 'Salamanca', 'Vicuña'],
        ],
        [
            'region' => 'Región Aisén del Gral. Carlos Ibáñez del Campo',
            'comunas' => ['Aisén', 'Chile Chico', 'Cisnes', 'Cochrane', 'Coihaique', 'Guaitecas', 'Lago Verde', 'O’Higgins', 'Río Ibáñez', 'Tortel'],
        ],
        [
            'region' => 'Región de Ñuble',
            'comunas' => ['Bulnes', 'Chillán', 'Chillán Viejo', 'Cobquecura', 'Coelemu', 'Coihueco', 'El Carmen', 'Ninhue', 'Ñiquén', 'Pemuco', 'Pinto', 'Portezuelo', 'Quillón', 'Quirihue', 'Ránquil', 'San Carlos', 'San Fabián', 'San Ignacio', 'San Nicolás', 'Treguaco', 'Yungay'],
        ],
        [
            'region' => 'Región de Magallanes y de la Antártica Chilena',
            'comunas' => ['Antártica', 'Cabo de Hornos (Ex Navarino)', 'Laguna Blanca', 'Natales', 'Porvenir', 'Primavera', 'Punta Arenas', 'Río Verde', 'San Gregorio', 'Timaukel', 'Torres del Paine'],
        ],
        [
            'region' => 'Región del Biobío',
            'comunas' => ['Alto Biobío', 'Antuco', 'Arauco', 'Cabrero', 'Cañete', 'Chiguayante', 'Concepción', 'Contulmo', 'Coronel', 'Curanilahue', 'Florida', 'Hualpén', 'Hualqui', 'Laja', 'Lebu', 'Los Álamos', 'Los Ángeles', 'Lota', 'Mulchén', 'Nacimiento', 'Negrete', 'Penco', 'Quilaco', 'Quilleco', 'San Pedro de la Paz', 'San Rosendo', 'Santa Bárbara', 'Santa Juana', 'Talcahuano', 'Tomé', 'Tirúa', 'Tucapel', 'Yumbel'],
        ],
        [
            'region' => 'Región del Libertador Gral. Bernardo O’Higgins',
            'comunas' => ['Chépica', 'Chimbarongo', 'Codegua', 'Coinco', 'Coltauco', 'Doñihue', 'Graneros', 'La Estrella', 'Las Cabras', 'Litueche', 'Lolol', 'Machalí', 'Malloa', 'Marchihue', 'Mostazal', 'Nancagua', 'Navidad', 'Olivar', 'Palmilla', 'Paredones', 'Peralillo', 'Peumo', 'Pichilemu', 'Pichidegua', 'Placilla', 'Pumanque', 'Quinta de Tilcoco', 'Rancagua', 'Rengo', 'Requínoa', 'San Fernando', 'San Vicente', 'Santa Cruz'],
        ],
        [
            'region' => 'Región del Maule',
            'comunas' => ['Cauquenes', 'Chanco', 'Colbún', 'Constitución', 'Curepto', 'Curicó', 'Empedrado', 'Hualañé', 'Licantén', 'Linares', 'Longaví', 'Maule', 'Parral', 'Pelarco', 'Pelluhue', 'Pencahue', 'Talca', 'Río Claro', 'San Clemente', 'San Rafael', 'Molina', 'Rauco', 'Retiro', 'Romeral', 'Sagrada Familia', 'San Javier', 'Teno', 'Vichuquén', 'Villa Alegre', 'Yerbas Buenas'],
        ],
        [
            'region' => 'Región de la Araucanía',
            'comunas' => ['Angol', 'Carahue', 'Cholchol', 'Collipulli', 'Cunco', 'Curacautín', 'Curarrehue', 'Ercilla', 'Freire', 'Galvarino', 'Gorbea', 'Lautaro', 'Loncoche', 'Lonquimay', 'Los Sauces', 'Lumaco', 'Melipeuco', 'Nueva Imperial', 'Padre las Casas', 'Perquenco', 'Pitrufquén', 'Pucón', 'Purén', 'Renaico', 'Saavedra', 'Teodoro Schmidt', 'Temuco', 'Toltén', 'Traiguén', 'Vilcún', 'Villarrica', 'Victoria'],
        ],
        [
            'region' => 'Región de Los Lagos',
            'comunas' => ['Ancud', 'Castro', 'Calbuco', 'Chaitén', 'Chonchi', 'Cochamó', 'Curaco de Vélez', 'Dalcahue', 'Fresia', 'Frutillar', 'Futaleufú', 'Hualaihué', 'Los Muermos', 'Llanquihue', 'Maullín', 'Osorno', 'Palena', 'Puerto Octay', 'Puerto Montt', 'Puerto Varas', 'Purranque', 'Puqueldón', 'Puyehue', 'Queilén', 'Quellón', 'Quemchi', 'Quinchao', 'Río Negro', 'San Juan de la Costa', 'San Pablo'],
        ],
        [
            'region' => 'Región de Los Ríos',
            'comunas' => ['Corral', 'La Unión', 'Lago Ranco', 'Lanco', 'Los Lagos', 'Máfil', 'Mariquina', 'Paillaco', 'Panguipulli', 'Río Bueno', 'Valdivia'],
        ],
        [
            'region' => 'Región Metropolitana de Santiago',
            'comunas' => ['Alhué', 'Buin', 'Calera de Tango', 'Cerrillos', 'Cerro Navia', 'Colina', 'Conchalí', 'Curacaví', 'El Bosque', 'El Monte', 'Estación Central', 'Huechuraba', 'Independencia', 'Isla de Maipo', 'Lampa', 'La Cisterna', 'La Florida', 'La Granja', 'La Pintana', 'La Reina', 'Las Condes', 'Lo Barnechea', 'Lo Espejo', 'Lo Prado', 'Macul', 'María Pinto', 'Maipú', 'Melipilla', 'Ñuñoa', 'Padre Hurtado', 'Paine', 'Pedro Aguirre Cerda', 'Peñaflor', 'Peñalolén', 'Pirque', 'Providencia', 'Pudahuel', 'Puente Alto', 'Quilicura', 'Quinta Normal', 'Recoleta', 'Renca', 'Santiago', 'San Bernardo', 'San Joaquín', 'San José de Maipo', 'San Miguel', 'San Pedro', 'San Ramón', 'Talagante', 'Tiltil', 'Vitacura'],
        ],
        [
            'region' => 'Tarapacá',
            'comunas' => ['Alto Hospicio', 'Camiña', 'Colchane', 'Huara', 'Iquique', 'Pica', 'Pozo Almonte'],
        ],
        [
            'region' => 'Valparaíso',
            'comunas' => ['Valparaíso', 'Casablanca', 'Concón', 'Juan Fernández', 'Puchuncaví', 'Quintero', 'Viña del Mar', 'Isla de Pascua', 'Los Andes', 'Calle Larga', 'Rinconada', 'San Esteban', 'La Ligua', 'Cabildo', 'Papudo', 'Petorca', 'Zapallar', 'Quillota', 'Calera', 'Hijuelas', 'La Cruz', 'Nogales', 'San Antonio', 'Algarrobo', 'Cartagena', 'El Quisco', 'El Tabo', 'Santo Domingo', 'San Felipe', 'Catemu', 'Llaillay', 'Panquehue', 'Putaendo', 'Santa María', 'Quilpué', 'Limache', 'Olmué', 'Villa Alemana'],
        ],
    ];
@endphp
@section('content')
    @include('components.trademark-registration-app', [
        'title' => isset($fields['title']) && !empty($fields['title']) ? $fields['title'] : '',
        'step_1_label' =>
            isset($fields['step_1_label']) && !empty($fields['step_1_label']) ? $fields['step_1_label'] : '',
        'step_2_label' =>
            isset($fields['step_2_label']) && !empty($fields['step_2_label']) ? $fields['step_2_label'] : '',
        'step_3_label' =>
            isset($fields['step_3_label']) && !empty($fields['step_3_label']) ? $fields['step_3_label'] : '',
        'step_4_label' =>
            isset($fields['step_4_label']) && !empty($fields['step_4_label']) ? $fields['step_4_label'] : '',
        'back_button' =>
            isset($fields['back_button']) && !empty($fields['back_button']) ? $fields['back_button'] : '',
        'continue_button' =>
            isset($fields['continue_button']) && !empty($fields['continue_button'])
                ? $fields['continue_button']
                : '',
        'step_1_props' =>
            isset($fields['step_1_props']) && !empty($fields['step_1_props']) ? $fields['step_1_props'] : [],
        'step_2_props' =>
            isset($fields['step_2_props']) && !empty($fields['step_2_props']) ? $fields['step_2_props'] : [],
        'step_3_props' =>
            isset($fields['step_3_props']) && !empty($fields['step_3_props']) ? $fields['step_3_props'] : [],
        'step_4_props' =>
            isset($fields['step_4_props']) && !empty($fields['step_4_props']) ? $fields['step_4_props'] : [],
        'step_5_props' => $step_5_props,
    ])
@endsection
