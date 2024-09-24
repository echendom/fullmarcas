@extends('layouts.default')
@section('content')    
    @if (isset($fields['layout_modules']) && !empty($fields['layout_modules']))
        @foreach ($fields['layout_modules'] as $module)
            @if ($module['acf_fc_layout'])
                @include('components.' . $module['acf_fc_layout'], $module)
            @endif
        @endforeach
    @endif
@endsection