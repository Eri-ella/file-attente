@extends('layouts.connexion_layout')

@section('connexion-content')

    @include('client.services-shell', [
        'innerView' => 'client.service-content',
        'innerData' => ['service' => $service],
    ])
@endsection