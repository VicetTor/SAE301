@extends('Base')

@section('title','Page des séances')

@section('content')

    <div class="paragraphe-bienvenue">
        <p>
            <strong>Bienvenue dans le club : <!-- Récupérer nom du club avec la connexion !--> </strong>
            Sed mattis, erat sit amet gravida malesuada, elit augue egestas diam, tempus scelerisque nunc nisl vitae libero. Sed consequat feugiat massa. Nunc porta, eros in eleifend varius, erat leo rutrum dui, non convallis lectus orci ut nibh. Sed lorem massa, nonummy quis, egestas id, condimentum at, nisl. Maecenas at nibh. Aliquam et augue at nunc pellentesque ullamcorper. Duis nisl nibh, laoreet suscipit, convallis ut, rutrum id, enim. Phasellus odio. Nulla nulla elit, molestie non, scelerisque at, vestibulum eu, nulla. Ut odio nisl, facilisis id, mollis et, scelerisque nec, enim. Aenean sem leo, pellentesque sit amet, scelerisque sit amet, vehicula pellentesque, sapien.
        </p>
    </div>

    <div class="seances">

        <h2> Mes séances : </h2>

        <?php
            //  @foreach() @endforeach Faire un foreach de toutes les séances pour l'utilisateur connecté et créer des li pour chacune
        ?>
        <li> <!-- Mettre la première date  !--> </li>
        <li> <!-- Mettre l'heure !--> </li>

        <br>

        <p> <!-- Niveau du user !--> </p>
        <p> <!-- compétence : pour la requête : récupérer l'évaluation de la séance puis ability puis la compétence de l'ability !--> </p>


        <?php
            //  @foreach() @endforeach Faire foreach de chaque aptitudes à réaliser
        ?>
        <h3> A  <!--et  Aptitude Requise (aptitude id) pour la compétence !--> </h3>
    </div>

    <div class="progression">
        <input type="button" name="" value="Consulter ma progression">
    </div>

@endsection
