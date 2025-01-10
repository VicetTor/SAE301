@extends('Base')
@section('title','Page MDP Temporaires')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
@section('content')
<div class="justify-content-center">
    <h4 class="text-danger"> Ces informations sont confidentielles. Ne les partagez pas avec n'importe qui. </h1>
        
    @foreach ($users as $user)
    <div class="shadow-sm p-2 m-3 bg-body-secondary rounded">
            <h4 class="fw-bold d-inline p-2">{{ $user->USER_MAIL }}</h4>
            <p class="d-inline p-2">http://127.0.0.1:8000/firstconnexion?user={{ $user->USER_ID }}<p>
        </div>
    @endforeach
</div>
@endsection
