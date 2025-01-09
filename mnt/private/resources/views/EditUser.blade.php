@extends('Base')

@section('title', 'Modifier l\'utilisateur')

@section('content')

<h1 class="my-4">Modifier l'utilisateur</h1>

<form method="POST" action="{{ route('modification.users.update', $user->USER_ID) }}">
    @csrf
    <!-- Utilisez POST car la route est définie avec POST -->
    @method('POST')
    <!-- Ajoutez des champs pour les informations utilisateur -->
    <div class="form-group">
        <label for="USER_FIRSTNAME">Prénom</label>
        <input type="text" name="USER_FIRSTNAME" class="form-control" value="{{ $user->USER_FIRSTNAME }}">
    </div>
    <div class="form-group">
        <label for="USER_LASTNAME">Nom</label>
        <input type="text" name="USER_LASTNAME" class="form-control" value="{{ $user->USER_LASTNAME }}">
    </div>
    <div class="form-group">
        <label for="USER_LICENSENUMBER">Numéro de Licence</label>
        <input type="text" name="USER_LICENSENUMBER" class="form-control" value="{{ $user->USER_LICENSENUMBER }}">
    </div>
    <div class="form-group">
        <label for="USER_MAIL">Email</label>
        <input type="email" name="USER_MAIL" class="form-control" value="{{ $user->USER_MAIL }}">
    </div>
    <div class="form-group">
        <label for="USER_PHONENUMBER">Numéro de téléphone</label>
        <input type="text" name="USER_PHONENUMBER" class="form-control" value="{{ $user->USER_PHONENUMBER }}">
    </div>
    <div class="form-group">
        <label for="USER_ADDRESS">Adresse</label>
        <input type="text" name="USER_ADDRESS" class="form-control" value="{{ $user->USER_ADDRESS }}">
    </div>
    <div class="form-group">
        <label for="USER_POSTALCODE">Code postal</label>
        <input type="text" name="USER_POSTALCODE" class="form-control" value="{{ $user->USER_POSTALCODE }}">
    </div>
    <div class="form-group">
        <label for="TYPE_ID">Type</label>
        <input type="text" name="TYPE_ID" class="form-control" value="{{ $user->TYPE_ID }}">
    </div>
    <div class="form-group">
        <label for="LEVEL_ID_RESUME">Niveau</label>
        <input type="text" name="LEVEL_ID_RESUME" class="form-control" value="{{ $user->LEVEL_ID_RESUME }}">
    </div>
    <div class="form-group">
        <label for="USER_MEDICCERTIFICATEDATE">Date du certificat médical</label>
        <input type="date" name="USER_MEDICCERTIFICATEDATE" class="form-control" value="{{ $user->USER_MEDICCERTIFICATEDATE }}">
    </div>
    <button type="submit" class="btn btn-primary">Mettre à jour</button>
</form>

@endsection