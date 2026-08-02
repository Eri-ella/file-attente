@extends('layouts.client')

@section('client-content')
    @include('client.services-shell', [
        'innerView' => 'client.serviceGrid',
        'innerData' => [],
    ])
@endsection