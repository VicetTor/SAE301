@extends('Base')

@section('title', 'Création séance')
@section('navBarTitle', "Création d'une séance")
@section('content')

<!-- Message de succès -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('sessions.store') }}">
    @csrf

    <!-- Ligne 1 : Date et Heure -->
    <div class="range">
        <div>
            <p>Date</p>
            <input type="date" class="form-control" name="date" style="width:200px" required>
        </div>
        <div>
            <p>Heure</p>
            <input type="time" class="form-control" name="time" style="width:200px" required>
        </div>
    </div>

    <!-- Ligne 2 : Élève, Aptitude et Initiateur -->
    <div class="range">
        <div>
            <p>Élève</p>
            <select class="form-select" style="width:200px" name="user_id" required>
                <option selected>Choix de l'élève</option>
                @foreach ($users as $user)
                    <option value="{{ $user->USER_ID }}">
                        {{ $user->USER_FIRSTNAME }} {{ $user->USER_LASTNAME }} - {{ $user->TRAIN_LABEL }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <p>Aptitude</p>
            <select class="form-select" style="width:200px" name="aptitude_id" required>
                <option selected>Choix des aptitudes</option>
                @foreach ($aptitudes as $id => $label)
                    <option value="{{ $id }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <p>Initiateur</p>
            <select class="form-select" style="width:200px" name="initiator_id" required>
                <option selected>Choix de l'initiateur</option>
                @foreach ($initiators as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Boutons -->
    <div class="range">
        <button type="button" class="btn btn-outline-warning" onclick="window.history.back();">Retour</button>
        <button type="submit" class="btn btn-outline-primary">Valider</button>
    </div>
</form>

@endsection
