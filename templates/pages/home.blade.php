@extends('layouts.layout')

@section('title', 'Standalone Blade')

@section('content')

    @for( $i = 0; $i < 5; $i++)
        @include('components.div')
    @endfor

@endsection
