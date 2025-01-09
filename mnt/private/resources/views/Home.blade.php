@extends('Base')

@section('title','Accueil')

@section('content')
@foreach($clubName as $club)
    <h1 class="text-center">{{ $club }}</h1>
@endforeach



@endsection