@extends('layouts.connexion_layout')

@section('connexion-content')

    @include('client.services-shell', [
        'innerView' => 'client.serviceGrid',
        'innerData' => [],
    ])
@endsection