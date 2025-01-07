@extends('Base')

@section('title','a définir')

@section('content')

<!DOCTYPE html>
<html lang="fr">


<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />


  <title>Inscription/Connexion</title>
</head>
<main>

    @if(session('fail') == 1)
        <p> Erreur </p>
    @endif

    <form method="POST" action="">
    @csrf  
        <label for="email">Mail:</label>
        <input type="text" id="email" name="email" required>
        
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>
        
        <input type="submit" value="Connexion">
    </form>
    

    @if(session('mail'))
        <p>Bienvenue, votre email est : {{ session('user_mail') }}</p>
    @else
        <p>Aucun utilisateur connecté.</p>
    @endif

    <?php
    use Illuminate\Support\Facades\Session;

    Session::put('fail', 0);
    ?>
            
</main>
</html>
@endsection