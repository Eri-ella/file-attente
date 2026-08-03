@extends('layouts.client')

@section('client-content')
    @include('client.services-shell', [
        'innerView' => 'client.service-content',
        'innerData' => ['service' => $service],
    ])
@endsection