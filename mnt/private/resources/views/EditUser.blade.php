@extends('Base') <!-- Extends the "Base" layout template -->

@section('title', 'Modifier l\'utilisateur') <!-- Sets the title for this page to "Modify User" -->

@section('content') <!-- Starts the content section that will be injected into the base layout -->

<h1 class="my-4">Modifier l'utilisateur</h1> <!-- Heading for the page -->

<form method="POST" action="{{ route('modification.users.update', $user->USER_ID) }}"> <!-- Form that uses the POST method to update the user with the specific ID -->
    @csrf <!-- Laravel's CSRF token for security against cross-site request forgery -->
    @method('POST') <!-- This indicates that the form will use the POST method as defined in the route (despite the typical use of PUT/PATCH for updates) -->

    <!-- Form fields for user information -->

    <div class="form-group"> <!-- First Name input field -->
        <label for="USER_FIRSTNAME">Prénom</label> <!-- Label for first name -->
        <input type="text" name="USER_FIRSTNAME" class="form-control" value="{{ $user->USER_FIRSTNAME }}"> <!-- Input field for first name, with the current value filled from the database -->
    </div>

    <div class="form-group"> <!-- Last Name input field -->
        <label for="USER_LASTNAME">Nom</label> <!-- Label for last name -->
        <input type="text" name="USER_LASTNAME" class="form-control" value="{{ $user->USER_LASTNAME }}"> <!-- Input field for last name -->
    </div>

    <div class="form-group"> <!-- License Number input field -->
        <label for="USER_LICENSENUMBER">Numéro de Licence</label> <!-- Label for the license number -->
        <input type="text" name="USER_LICENSENUMBER" class="form-control" value="{{ $user->USER_LICENSENUMBER }}"> <!-- Input field for license number -->
    </div>

    <div class="form-group"> <!-- Email input field -->
        <label for="USER_MAIL">Email</label> <!-- Label for the email -->
        <input type="email" name="USER_MAIL" class="form-control" value="{{ $user->USER_MAIL }}"> <!-- Input field for email -->
    </div>

    <div class="form-group"> <!-- Phone Number input field -->
        <label for="USER_PHONENUMBER">Numéro de téléphone</label> <!-- Label for phone number -->
        <input type="text" name="USER_PHONENUMBER" class="form-control" value="{{ $user->USER_PHONENUMBER }}"> <!-- Input field for phone number -->
    </div>

    <div class="form-group"> <!-- Address input field -->
        <label for="USER_ADDRESS">Adresse</label> <!-- Label for address -->
        <input type="text" name="USER_ADDRESS" class="form-control" value="{{ $user->USER_ADDRESS }}"> <!-- Input field for the user's address -->
    </div>

    <div class="form-group"> <!-- Postal Code input field -->
        <label for="USER_POSTALCODE">Code postal</label> <!-- Label for postal code -->
        <input type="text" name="USER_POSTALCODE" class="form-control" value="{{ $user->USER_POSTALCODE }}"> <!-- Input field for postal code -->
    </div>

    <div class="form-group"> <!-- User Type input field -->
        <label for="TYPE_ID">Type</label> <!-- Label for the user type -->
        <input type="text" name="TYPE_ID" class="form-control" value="{{ $user->TYPE_ID }}"> <!-- Input field for user type -->
    </div>

    <div class="form-group"> <!-- User Level input field -->
        <label for="LEVEL_ID_RESUME">Niveau</label> <!-- Label for the user's level -->
        <input type="text" name="LEVEL_ID_RESUME" class="form-control" value="{{ $user->LEVEL_ID_RESUME }}"> <!-- Input field for the user's level -->
    </div>

    <div class="form-group"> <!-- Medical Certificate Date input field -->
        <label for="USER_MEDICCERTIFICATEDATE">Date du certificat médical</label> <!-- Label for the medical certificate date -->
        <input type="date" name="USER_MEDICCERTIFICATEDATE" class="form-control" value="{{ $user->USER_MEDICCERTIFICATEDATE }}"> <!-- Input field for medical certificate date -->
    </div>

    <button type="submit" class="btn btn-primary">Mettre à jour</button> <!-- Submit button to update the user's information -->

</form>

@endsection <!-- Ends the content section -->
