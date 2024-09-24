@extends('layouts.default')

@php
    $fields = get_field('error_tbk_page', 'option') ?? [];
@endphp

@section('content')
  @include('components.general-typ', $fields)
@endsection
