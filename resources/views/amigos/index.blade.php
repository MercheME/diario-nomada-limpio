
@extends('layouts.app')

@section('content')
    <h1>Mis Amigos</h1>
    <ul>
        @foreach($amigos as $amigo)
            <li>{{ $amigo->name }}</li>
        @endforeach
    </ul>
@endsection
