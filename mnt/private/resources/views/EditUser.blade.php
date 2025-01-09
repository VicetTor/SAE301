@extends('Base')

@section('title', 'Modifier l\'utilisateur')

@section('content')

<h1 class="my-4">Modifier l'utilisateur</h1>

<form action="{{ route('modification.users.update', $user->USER_ID) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Prénom -->
    <div class="mb-3">
        <label for="USER_FIRSTNAME" class="form-label">Prénom</label>
        <input type="text" class="form-control" id="USER_FIRSTNAME" name="USER_FIRSTNAME" value="{{ $user->USER_FIRSTNAME }}" required>
    </div>

    <!-- Nom -->
    <div class="mb-3">
        <label for="USER_LASTNAME" class="form-label">Nom</label>
        <input type="text" class="form-control" id="USER_LASTNAME" name="USER_LASTNAME" value="{{ $user->USER_LASTNAME }}" required>
    </div>

    <!-- Numéro de Licence -->
    <div class="mb-3">
        <label for="USER_LICENSENUMBER" class="form-label">Numéro de Licence</label>
        <input type="text" class="form-control" id="USER_LICENSENUMBER" name="USER_LICENSENUMBER" value="{{ $user->USER_LICENSENUMBER }}" required>
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label for="USER_MAIL" class="form-label">Email</label>
        <input type="email" class="form-control" id="USER_MAIL" name="USER_MAIL" value="{{ $user->USER_MAIL }}" required>
    </div>

    <!-- Numéro de téléphone -->
    <div class="mb-3">
        <label for="USER_PHONENUMBER" class="form-label">Numéro de téléphone</label>
        <input type="tel" class="form-control" id="USER_PHONENUMBER" name="USER_PHONENUMBER" value="{{ $user->USER_PHONENUMBER }}">
    </div>

    <!-- Adresse -->
    <div class="mb-3">
        <label for="USER_ADDRESS" class="form-label">Adresse</label>
        <input type="text" class="form-control" id="USER_ADDRESS" name="USER_ADDRESS" value="{{ $user->USER_ADDRESS }}">
    </div>

    <!-- Code Postal -->
    <div class="mb-3">
        <label for="USER_POSTALCODE" class="form-label">Code Postal</label>
        <input type="text" class="form-control" id="USER_POSTALCODE" name="USER_POSTALCODE" value="{{ $user->USER_POSTALCODE }}">
    </div>

    <!-- Type (status) -->
    <div class="mb-3">
        <label for="TYPE_ID" class="form-label">Type (Statut)</label>
        <select class="form-control" id="TYPE_ID" name="TYPE_ID">
            <option value="1" {{ $user->TYPE_ID == 1 ? 'selected' : '' }}>Statut 1</option>
            <option value="2" {{ $user->TYPE_ID == 2 ? 'selected' : '' }}>Statut 2</option>
            <!-- Ajoutez d'autres statuts si nécessaire -->
        </select>
    </div>

    <!-- Niveau -->
    <div class="mb-3">
        <label for="LEVEL_ID_RESUME" class="form-label">Niveau</label>
        <select class="form-control" id="LEVEL_ID_RESUME" name="LEVEL_ID_RESUME">
            <option value="1" {{ $user->LEVEL_ID_RESUME == 1 ? 'selected' : '' }}>Niveau 1</option>
            <option value="2" {{ $user->LEVEL_ID_RESUME == 2 ? 'selected' : '' }}>Niveau 2</option>
            <!-- Ajoutez d'autres niveaux si nécessaire -->
        </select>
    </div>

    <!-- Date de certification médicale -->
    <div class="mb-3">
        <label for="USER_MEDICCERTIFICATEDATE" class="form-label">Date de certification médicale</label>
        <input type="date" class="form-control" id="USER_MEDICCERTIFICATEDATE" name="USER_MEDICCERTIFICATEDATE" value="{{ $user->USER_MEDICCERTIFICATEDATE }}">
    </div>

    <!-- Bouton de soumission -->
    <button type="submit" class="btn btn-success">Enregistrer les modifications</button>
</form>

@endsection
