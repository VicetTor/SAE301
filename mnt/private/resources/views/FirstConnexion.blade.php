@extends('Base')

@section('title','a définir')

@section('content')

    <div>
        <label for="USER_PASSWORD">Mot de passe Actuel</label>
        <input type="text" id="USER_PASSWORD" name="USER_PASSWORD" value={{$utilisateur->USER_PASSWORD}}>
        <!-- Error message for the current password if validation fails -->
        @error('USER_PASSWORD')
        <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>

    <!-- Form to change the password -->
    <form action="" method="POST">
        @csrf
        <!-- New password input section -->
        <div>
            <label for="USER_PASSWORD">Nouveau mot de passe</label>
            <input type="text" id="USER_PASSWORD" name="USER_PASSWORD"  >
            <!-- Error message for the new password if validation fails -->
            @error('USER_PASSWORD')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit button to confirm password change -->
        <div>
            <button type="submit">Confirmation de changement de mot de passe</button>
        </div>
    </form>

@endsection
