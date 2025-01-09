@extends('Base')

@section('title', 'Formation')

@section('content')

<div class="container mt-5">
    <div class="card p-4 shadow-lg">
        <div class="card-body">
            <h1 class="text-center mb-4">📁 Bienvenue sur la page d'accueil des formations, {{ session('user_firstname') . ' ' . session('user_lastname') }}</h1>
            <div class="row justify-content-center">
                @if(session('type_id') == 4)
                    <div class="col-md-4 mb-3 text-center">
                        <a href="{{ route('forms.views.dt.creation') }}" class="btn btn-primary btn-lg btn-block">
                            Créer une formation
                        </a>
                    </div>
                @endif

                @if(session('type_id') == 3 || session('type_id') == 4)
                    <div class="col-md-4 mb-3 text-center">
                        <a href="{{ route('forms.views.edit.responsable.add') }}" class="btn btn-success btn-lg btn-block">
                            Ajouter dans une formation
                        </a>
                    </div>
                @endif

                @if(session('type_id') == 3 || session('type_id') == 4)
                    <div class="col-md-4 mb-3 text-center">
                        <a href="{{ route('forms.views.edit.responsable.remove') }}" class="btn btn-danger btn-lg btn-block">
                            Supprimer d'une formation
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection