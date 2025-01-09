@extends('Base')

@section('title','Modification du profil')

@section('navBarTitle','Modification du profil')

@section('content')
<div class="row">
    <h4 class="text-danger text-center"> Ne modifiez que ce que vous souhaitez changer </h2>
    @if ($errors->any()) 
        <div class="alert alert-danger"> 
            <ul> 
                @foreach ($errors->all() as $error) 
                    <li>{{ $error }}</li> 
                @endforeach 
            </ul> 
        </div> 
    @endif
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
                    <input type="text" class="form-control" id="inputAddress" name="inputAddress" placeholder="N° Rue Ville" title="N° Rue Ville" value="{{ Session('user_address') }}"  max='255' required>
                </div>
                <div class="mb-3">
                    <label for="inputPostalCode" class="form-label">Code postal :</label>
                    <input type="text" class="form-control" id="inputPostalCode" name="inputPostalCode" value="{{ Session('user_postalcode') }}"  required>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Valider les modifications</button>
    </form>
        
    <form action="{{ route('pswdUserUpdate') }}" method="POST" class="col align-self-baseline row">
        @csrf 
        <div class="shadow-sm p-3 mb-5 bg-body-secondary rounded ">
            <div class="mb-3">
                <label for="inputActualPassword" class="form-label">Mot de passe actuel :</label>
                <input type="password" class="form-control" id="inputActualPassword" name="inputActualPassword" required >
            </div>
            <div class="mb-3">
                <label for="inputNewPassword" class="form-label">Nouveau Mot de passe :</label>
                <input type="password" class="form-control" id="inputNewPassword" name="inputNewPassword" min='6' pattern='^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$' title='Minimum : 6 caractères, 1 MAJUSCULE, 1 minuscule, 1 chiffre ' required> 
            </div>
            <div class="mb-3">
                <label for="inputPasswordVerif" class="form-label">Vérification du Mot de passe :</label>
                <input type="password" class="form-control" id="inputPasswordVerif"  name="inputPasswordVerif" min='6' pattern='^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$' title='Validation du mot de passe' required>
            </div>
            <button type="submit" class="btn btn-primary ">Valider les modifications</button>

        </div>
    </form>
</div>
        
        
@endsection