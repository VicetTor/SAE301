@extends('Base')

@section('title','Modification du profil')

@section('navBarTitle','Modification du profil')

@section('content')
<!-- vous bossez la dedans adresse mail adresse mdp num tel-!-->
<div class="row">
    <h4 class="text-danger text-center"> Ne modifiez que ce que vous voulez changer </h2>
    
    <form action="{{ route('infoUserUpdate') }}" method="POST" class="col align-self-start row">
        @csrf    
        <div class="col align-self-start">  
            <div class="shadow-sm p-3 mb-5 bg-body-secondary rounded">
                <div class="mb-3">
                    <label for="inputEmail" class="form-label">Adresse mail :</label>
                    <input type="email" class="form-control" id="inputEmail" name="inputEmail"  value="{{ Session('user_mail') }}" max='255' required>
                </div>
            </div>
            <div class="shadow-sm p-3 mb-5 bg-body-secondary rounded">
                <div class="mb-3">
                    <label for="inputPhoneNumber" class="form-label">Numéro de téléphone :</label>
                    <input type="text" class="form-control" id="inputPhoneNumber" name="inputPhoneNumber" value="{{ Session('user_phonenumber') }}" min='10' max='10' required>
                </div>
            </div>
            <div class="shadow-sm p-3 mb-5 bg-body-secondary rounded">
                <div class="mb-3">
                    <label for="inputAddress" class="form-label">Adresse :</label>
                    <input type="text" class="form-control" id="inputAddress" name="inputAddress" value="{{ Session('user_address') }}"  max='255' required>
                </div>
                <div class="mb-3">
                    <label for="inputPostalCode" class="form-label">Code postal :</label>
                    <input type="text" class="form-control" id="inputPostalCode" name="inputPostalCode" value="{{ Session('user_postalcode') }}"  required>
                </div>
            </div>
        </div>
        @if ($errors->any()) 
            <div class="alert alert-danger"> 
                <ul> 
                    @foreach ($errors->all() as $error) 
                        <li>{{ $error }}</li> 
                    @endforeach 
                </ul> 
            </div> 
        @endif
        <button type="submit" class="btn btn-primary">Valider les modifications</button>
    </form>
        
    <form action="{{ route('pswdUserUpdate') }}" method="POST" class="col align-self-baseline row">
        <div class="shadow-sm p-3 mb-5 bg-body-secondary rounded ">
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
            <button type="submit" class="btn btn-primary ">Valider les modifications</button>

        </div>
    </form>
</div>
        
        
@endsection