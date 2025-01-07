@extends('Base')

@section('title','Mon profil')

@section('navBarTitle','Mon Profil')

@section('content')
    <div class="text-center">
        <h1> Bienvenue, VARIABLE_NOM <h1>
            <div id="displayPersonnalInformation" class="rounded shadow-sm p-3 mb-5 bg-body-tertiary text-start rrounded">
                <h3> Informations Personnelles </h3>
                <div class="fs-5">
                    <div> <h4 class="fw-bold d-inline p-2"> Nom : </h4> <p class="d-inline p-2"> VARIABLE_NOM </p></div>
                    <div> <h4 class="fw-bold d-inline p-2"> Prénom : </h4> <p class="d-inline p-2">VARIABLE_PRENOM </p></div>
                    <div> <h4 class="fw-bold d-inline p-2">Date de naissance : </h4><p class="d-inline p-2"> VARIABLE_DATENAISSANCE </p></div>
                    <div> <h4 class="fw-bold d-inline p-2"> Adresse Postale : </h4><p class="d-inline p-2"> VARIABLE_ADRESSE VARIABLE_CODEPOSTAL</p></div>
                    <div> <h4 class="fw-bold d-inline p-2">  Adresse mail : </h4><p class="d-inline p-2"> VARIABLE_MAIL </p></div>
                    <div> <h4 class="fw-bold d-inline p-2">Mot de passe : </h4> <p class="d-inline p-2">********* </p></div>
                    <div> <h4 class="fw-bold d-inline p-2">  Numéro de téléphone :</h4><p class="d-inline p-2"> VARIABLE_TELEPHONE </p></div>
                    <div> <h4 class="fw-bold d-inline p-2"> Numéro de licence : </h4><p class="d-inline p-2"> VARIABLE_LICENCE </p></div>
                    <div> <h4 class="fw-bold d-inline p-2">Niveau Actuel : </h4><p class="d-inline p-2"> VARIABLE_NIVEAUACTUEL</p></div>
                    <div> <h4 class="fw-bold d-inline p-2"> Niveau en préparation : </h4><p class="d-inline p-2"> VARIABLE_NIVEAUPREPARATION</p></div>
                </div>
            </div>
            <a href="/user"><button id="buttonUserModifying" type="button" class="btn btn-primary" >Modifier mes informations</button></a>
            <a href="#"><button id="buttonUserDeleting" type="button" class="btn btn-danger">Supprimer mon compte</button></a> 
            <!-- Contacter le service pour supprimer votre compte -->
    </div>
@endsection