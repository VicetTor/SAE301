@extends('Base')

@section('title','a définir')

@section('content')

    <!-- Form to change the password -->
    <!-- Form to update the user's password -->
    <form action="{{ route('firstconnexion') }}" method="POST" class="col align-self-baseline row">
        @csrf 

        <!-- Section for password change -->
        <div class="shadow-sm p-3 mb-5 bg-body-secondary rounded ">

            <!-- Input for the new password -->
            <div class="mb-3">
                <label for="inputNewPassword" class="form-label">Nouveau Mot de passe :</label> <!-- French: New Password -->
                <input type="password" class="form-control" id="inputNewPassword" name="inputNewPassword" min='6' pattern='^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$' title='Minimum : 6 caractères, 1 MAJUSCULE, 1 minuscule, 1 chiffre ' required> 
            </div>

            <!-- Input to verify the new password -->
            <div class="mb-3">
                <label for="inputPasswordVerif" class="form-label">Vérification du Mot de passe :</label> <!-- French: Password Verification -->
                <input type="password" class="form-control" id="inputPasswordVerif"  name="inputPasswordVerif" min='6' pattern='^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$' title='Validation du mot de passe' required>
            </div>

            <!-- Button to submit the password changes -->
            <button type="submit" class="btn btn-primary ">Valider les modifications</button> <!-- French: Confirm Changes -->
        </div>
    </form>

@endsection
