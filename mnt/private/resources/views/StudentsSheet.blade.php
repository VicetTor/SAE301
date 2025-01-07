@extends('Base')

@section('title','a définir')

@section('content')

@if(session('mail'))
        <p>bonjour {{ session('user_mail') }}</p>
    @else
        <p>Aucun utilisateur connecté.</p>
    @endif

    
@endsection
