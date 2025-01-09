@extends('Base')

@section('title','Mon profil')

@section('navBarTitle','Mon Profil')

@section('content')
<div class="text-center">
    <h1> Bienvenue, <?php echo Session('user_firstname'); ?> <h1>
            <div id="displayPersonnalInformation" class="rounded shadow-sm p-3 mb-5 bg-body-tertiary text-start rrounded">
                <h3> Informations Personnelles </h3>
                <div class="fs-5">
                    <div>
                        <h4 class="fw-bold d-inline p-2"> Nom : </h4>
                        <p class="d-inline p-2"> {{ Session('user_lastname') }} </p>
                    </div>
                    <div>
                        <h4 class="fw-bold d-inline p-2"> Prénom : </h4>
                        <p class="d-inline p-2"> {{ Session('user_firstname'); }}</p>
                    </div>
                    <div>
                        <h4 class="fw-bold d-inline p-2"> Date de naissance : </h4>
                        <p class="d-inline p-2"> {{ Session('user_birthdate'); }} </p>
                    </div>
                    <div>
                        <h4 class="fw-bold d-inline p-2"> Adresse Postale : </h4>
                        <p class="d-inline p-2"> {{ Session('user_address') }} {{ Session('user_postalcode'); }}</p>
                    </div>
                    <div>
                        <h4 class="fw-bold d-inline p-2"> Adresse mail : </h4>
                        <p class="d-inline p-2"> {{ Session('user_mail'); }} </p>
                    </div>
                    <div>
                        <h4 class="fw-bold d-inline p-2"> Mot de passe : </h4>
                        <p class="d-inline p-2">********* </p>
                    </div>
                    <div>
                        <h4 class="fw-bold d-inline p-2"> Numéro de téléphone : </h4>
                        <p class="d-inline p-2"> {{ Session('user_phonenumber'); }} </p>
                    </div>
                    <div>
                        <h4 class="fw-bold d-inline p-2"> Numéro de licence : </h4>
                        <p class="d-inline p-2"> {{ Session('user_licensenumber'); }} </p>
                    </div>
                    <div>
                        <h4 class="fw-bold d-inline p-2"> Niveau Actuel : </h4>
                        <p class="d-inline p-2"> {{ Session('level_id'); }}</p>
                    </div>
                    <?php if (Session('type_id') == 4) {
                        echo '<div> <h4 class="fw-bold d-inline p-2"> Niveau en préparation : </h4><p class="d-inline p-2">' . Session('level_id_resume') . '</p></div>';
                    } ?>
                </div>
            </div>
            <div>
            <a href="/user"><button id="buttonUserModifying" type="button" class="btn btn-primary">Modifier mes informations</button></a>
            <button id="buttonUserDeleting" type="button" class="btn btn-danger" data-toggle="modal" data-target="#popupDeletion">Supprimer mon compte</button>
            </div>
            <a href="/logOut"><button id="buttonlogOut" type="button" class="btn btn-primary">Se déconnecter</button></a>
            <!-- Contacter le service pour supprimer votre compte -->
            <div id="popupDeletion" class="modal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header text-danger">
                            <h5> Afin de supprimer votre compte, vous devez contacter votre directeur technique </h5>
                        </div>
                        <div class="modal-body">
                            <h6> Adresse Mail: {{$popUps->USER_MAIL}} </h6>
                            <h6> Numéro de téléphone: {{$popUps->USER_PHONENUMBER}} </h6>
                            <br>
                            <div class="d-flex justify-content-center"> 
                                <button data-mdb-button-init data-mdb-ripple-init class="col-lg-2 btn btn-light btn-outline-dark" type="button" data-dismiss="modal"><i class="bi bi-check-lg"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>
@endsection