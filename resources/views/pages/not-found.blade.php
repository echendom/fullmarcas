@extends('layouts.default')
@php
    $fields = get_field('error_404_page', 'option') ?? [];
@endphp
@section('content')
  @include('components.general-typ', $fields)
@endsection
