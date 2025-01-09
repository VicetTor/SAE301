@extends('Base')

@section('title','a définir')

@section('content')

    <form action="" method="POST">
        @csrf


        <!-- Nom -->
        <div>
            <label for="USER_PASSWORD">Nouveau mot de passe</label>
            <input type="text" id="USER_PASSWORD" name="USER_PASSWORD"  >
            @error('USER_PASSWORD')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>


        <!-- Prénom -->
        <div>
            <label for="USER_FIRSTNAME">Confirmation nouveau mot de passe</label>
            <input type="text" id="USER_FIRSTNAME" name="USER_FIRSTNAME" >
            @error('USER_PASSWORD')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Bouton d'inscription -->
        <div>
            <button type="submit">Confirmation de changement de mot de passe</button>
        </div>
    </form>


@endsection
