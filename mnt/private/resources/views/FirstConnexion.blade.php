@extends('Base')

@section('title','a définir')

@section('content')


    <div>
        <label for="USER_PASSWORD">Mot de passe Actuel</label>
        <input type="text" id="USER_PASSWORD" name="USER_PASSWORD" value={{$utilisateur->USER_PASSWORD}}>
        @error('USER_PASSWORD')
        <span style="color: red;">{{ $message }}</span>
        @enderror
    </div>

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

        <!-- Bouton d'inscription -->
        <div>
            <button type="submit">Confirmation de changement de mot de passe</button>
        </div>
    </form>


@endsection
