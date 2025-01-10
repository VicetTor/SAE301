@extends('Base')

@section('title','a définir')

@section('content')
    <?php
        use App\Models\User;
    ?>
    <h1>Valider les compétences</h1>

    <?php
        $user = User::select('*')->get();

        foreach($user as $user){
            echo'<p>'.$user->USER_FIRSTNAME.'</p>';
        }
    ?>
@endsection
