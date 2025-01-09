@extends('Base')

@section('title', 'Modification des utilisateurs')

@section('content')

<h1 class="my-4">Gestion des utilisateurs</h1>

<!-- Barre de recherche -->
<form method="GET" action="{{ route('modification.users.search') }}" class="d-flex mb-4">
    <input type="text" name="search" class="form-control me-2" placeholder="Nom ou Licence" value="{{ request()->get('search') }}">
    <button type="submit" class="btn btn-primary">Rechercher</button>
</form>

<!-- Liste des utilisateurs -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Numéro de Licence</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->USER_FIRSTNAME }}</td>
            <td>{{ $user->USER_LASTNAME }}</td>
            <td>{{ $user->USER_LICENSENUMBER }}</td>
            <td class="d-flex">
                @if ($canEdit)
                    <!-- Bouton Modifier -->
                    <a href="{{ route('modification.users.edit', $user->USER_ID) }}" class="btn btn-warning me-2">Modifier</a>

                    <!-- Formulaire pour supprimer -->
                    <form action="{{ route('modification.users.delete', $user->USER_ID) }}" method="POST" class="d-inline">
                        @csrf
                        @method('POST') <!-- Assurez-vous que DELETE fonctionne en POST-->
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection