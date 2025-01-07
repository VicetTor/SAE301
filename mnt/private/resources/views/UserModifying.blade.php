@extends('Base')

@section('title','Modification du profil')

@section('navBarTitle','Modification du profil')

@section('content')
    <!-- vous bossez la dedans adresse mail adresse mdp num tel-!-->
    <form class="row">
        <h4 class="text-danger text-center"> Ne modifiez que ce que vous voulez changer </h2>
        
        <div class="col align-self-start">
            <div class="shadow-sm p-3 mb-5 bg-body-secondary rounded">
                <div class="mb-3">
                    <label for="inputEmail" class="form-label">Adresse mail :</label>
                    <input type="email" class="form-control" id="exampleInputEmail">
                </div>
            </div>
            <div class="shadow-sm p-3 mb-5 bg-body-secondary rounded">
                <div class="mb-3">
                    <label for="inputActualPassword" class="form-label">Mot de passe actuel :</label>
                    <input type="password" class="form-control" id="inputActualPassword">
                </div>
                <div class="mb-3">
                    <label for="inputNewPassword" class="form-label">Nouveau Mot de passe :</label>
                    <input type="password" class="form-control" id="inputNewPassword">
                </div>
                <div class="mb-3">
                    <label for="inputPasswordVerif" class="form-label">Vérification du Mot de passe :</label>
                    <input type="password" class="form-control" id="inputPasswordVerif">
                </div>
            </div>
        </div>
        
        <div class="col align-self-end">
            <div class="shadow-sm p-3 mb-5 bg-body-secondary rounded">
                <div class="mb-3">
                    <label for="inputPhoneNumber" class="form-label">Numéro de téléphone :</label>
                    <input type="text" class="form-control" id="inputPhoneNumber">
                </div>
            </div>
            <div class="shadow-sm p-3 mb-5 bg-body-secondary rounded">
                <div class="mb-3">
                    <label for="inputPostalCode" class="form-label">Code postal :</label>
                    <input type="text" class="form-control" id="inputPostalCode">
                </div>
                <div class="mb-3">
                    <label for="inputCity" class="form-label">Ville :</label>
                    <input type="text" class="form-control" id="inputCity">
                </div>
                <div class="mb-3">
                    <label for="inputStreet" class="form-label">N° Rue et rue :</label>
                    <input type="text" class="form-control" id="inputStreet">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Valider les modifications</button>
    </form>
@endsection
