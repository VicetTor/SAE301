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
        @if($user->USER_ID != Session('user_id'))
        <tr>
            <!-- User's first name -->
            <td>{{ $user->USER_FIRSTNAME }}</td>
            <!-- User's last name -->
            <td>{{ $user->USER_LASTNAME }}</td>
            <!-- User's license number -->
            <td>{{ $user->USER_LICENSENUMBER }}</td>
            <td class="d-flex">
                @if ($canEdit) <!-- Check if the user has permission to edit -->
                    <!-- Edit button for each user -->
                    <a href="{{ route('modification.users.edit', $user->USER_ID) }}" class="btn btn-warning me-2">Modifier</a>

                    <!-- Form to delete the user -->
                    <form action="{{ route('modification.users.delete', $user->USER_ID) }}" method="POST" class="d-inline">
                        @csrf
                        @method('POST') <!-- Ensures DELETE method works with POST -->
                        <!-- Delete button -->
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                @endif
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
    <button id="buttonUserDeleting" type="button" class="btn btn-danger" data-toggle="modal" data-target="#popupPassword">Voir mots de passe temporaires</button>
    <br>

</table>

 <div id="popupPassword" class="modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-danger">
                <!-- Warning message about account deletion -->
                <h5> Afin de supprimer votre compte, vous devez contacter votre directeur technique </h5>
            </div>
            <div class="modal-body">
                <!-- Contact information of the technical director -->
                <h6> Adresse Mail: {{$popUps->USER_MAIL}} </h6>
                <h6> Numéro de téléphone: {{$popUps->USER_PHONENUMBER}} </h6>
                <br>
                <!-- Button to close the modal -->
                <div class="d-flex justify-content-center"> 
                    <button data-mdb-button-init data-mdb-ripple-init class="col-lg-2 btn btn-light btn-outline-dark" type="button" data-dismiss="modal"><i class="bi bi-check-lg"></i></button>
                </div>
            </div>
        </div>
    </div>
</div> 

@endsection
