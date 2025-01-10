@extends('Base')

@section('title', 'Modification des utilisateurs')

@section('content')

<!-- Main heading for user management -->
<h1 class="my-4">Gestion des utilisateurs</h1>

<!-- Search bar form to search users by name or license number -->
<form method="GET" action="{{ route('modification.users.search') }}" class="d-flex mb-4">
    <!-- Input field for the search query (name or license number) -->
    <input type="text" name="search" class="form-control me-2" placeholder="Nom ou Licence" value="{{ request()->get('search') }}">
    <!-- Search button -->
    <button type="submit" class="btn btn-primary">Rechercher</button>
</form>

<!-- Table displaying the list of users -->
<table class="table table-striped">
    <thead>
        <tr>
            <!-- Table headers -->
            <th>Prénom</th>
            <th>Nom</th>
            <th>Numéro de Licence</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <!-- Loop through each user and display their details in the table rows -->
        @foreach ($users as $user)
        @if($user->USER_ID != Session('user_id') && $clubs_id->CLUB_ID == $user->CLUB_ID)
        <tr>
            <!-- User's first name -->
            <td>{{ $user->USER_FIRSTNAME }}</td>
            <!-- User's last name -->
            <td>{{ $user->USER_LASTNAME }}</td>
            <!-- User's license number -->
            <td>{{ $user->USER_LICENSENUMBER }}</td>
            <td class="d-flex">
                <!-- Edit button for each user -->
                <a href="{{ route('modification.users.edit', $user->USER_ID) }}" class="btn btn-warning me-2">Modifier</a>

                <!-- Form to delete the user -->
                <form action="{{ route('modification.users.delete', $user->USER_ID) }}" method="POST" class="d-inline">
                    @csrf
                    @method('POST') <!-- Ensures DELETE method works with POST -->
                    <!-- Delete button -->
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
    
    <a href="/modification/users/temporaryPassword"><button id="buttonTempPswd" type="button" class="btn btn-primary">Voir Mots de Passe Temporaires</button></a>
</form>
    <br>

</table>

@endsection
