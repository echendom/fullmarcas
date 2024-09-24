@php
  $title = isset($title) && !empty($title) ? $title : '';
  $step_1_label = isset($step_1_label) && !empty($step_1_label) ? $step_1_label : '';
  $step_2_label = isset($step_2_label) && !empty($step_2_label) ? $step_2_label : '';
  $step_3_label = isset($step_3_label) && !empty($step_3_label) ? $step_3_label : '';
  $step_4_label = isset($step_4_label) && !empty($step_4_label) ? $step_4_label : '';
  $step_1_props = isset($step_1_props) && !empty($step_1_props) ? $step_1_props : [];
  $step_2_props = isset($step_2_props) && !empty($step_2_props) ? $step_2_props : [];
  $step_3_props = isset($step_3_props) && !empty($step_3_props) ? $step_3_props : [];
  $step_4_props = isset($step_4_props) && !empty($step_4_props) ? $step_4_props : [];
  $step_5_props = isset($step_5_props) && !empty($step_5_props) ? $step_5_props : [];
  $back_button = isset($back_button) && !empty($back_button) ? $back_button : [];
  $continue_button = isset($continue_button) && !empty($continue_button) ? $continue_button : [];
@endphp

<v-trademark-registration
  title="{{ $title }}"
  step_1_label="{{ $step_1_label }}"
  step_2_label="{{ $step_2_label }}"
  step_3_label="{{ $step_3_label }}"
  step_4_label="{{ $step_4_label }}"
  back_button="{{ $back_button }}"
  continue_button="{{ $continue_button }}"
  :step_1_props="{{ json_encode($step_1_props) }}"
  :step_2_props="{{ json_encode($step_2_props) }}"
  :step_3_props="{{ json_encode($step_3_props) }}"
  :step_4_props="{{ json_encode($step_4_props) }}"
  :step_5_props="{{ json_encode($step_5_props) }}"
></v-trademark-registration>

@include('components.socials', [
    'socials' => get_field('header', 'option')['socials'] ?? [],
])