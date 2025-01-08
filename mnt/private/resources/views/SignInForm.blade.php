@extends('Base')

@section('title','a définir')

@section('content')


    <form action="" method="POST">
        @csrf


        <!-- Nom -->
        <div>
            <label for="USER_LASTNAME">Nom</label>
            <input type="text" id="USER_LASTNAME" name="USER_LASTNAME" value="{{ old('USER_LASTNAME') }}" >
            @error('USER_LASTNAME')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>


        <!-- Prénom -->
        <div>
            <label for="USER_FIRSTNAME">Prénom</label>
            <input type="text" id="USER_FIRSTNAME" name="USER_FIRSTNAME" value="{{ old('USER_FIRSTNAME') }}" >
            @error('USER_FIRSTNAME')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Statut -->
        <div>
            <label for="TYPE_ID">Statut</label>
            <select name="TYPE_ID" id="TYPE_ID">
                <option value=""></option>
                @foreach($typeUser as $user)
                    <option value="{{$user->TYPE_ID}}">{{$user->TYPE_LABEL}}</option>
                @endforeach
            </select>
            @error('TYPE_ID')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Code Postal -->
        <div>
            <label for="USER_POSTALCODE">Code Postal</label>
            <input type="text" id="USER_POSTALCODE" name="USER_POSTALCODE" value="{{ old('USER_POSTALCODE') }}" >
            @error('USER_POSTALCODE')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>


        <!-- Email -->
        <div>
            <label for="USER_MAIL">Adresse e-mail</label>
            <input type="email" id="USER_MAIL" name="USER_MAIL" value="{{ old('USER_MAIL') }}" >
            @error('USER_MAIL')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>


        <!-- Date de Naissance -->

        <div>
            <label for="USER_BIRTHDATE">Date de Naissance</label>
            <input type="date" id="USER_BIRTHDATE" name="USER_BIRTHDATE" value="{{ old('USER_BIRTHDATE') }}" >
            @error('USER_BIRTHDATE')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Numéro de licence -->
        <div>
            <label for="USER_LICENSENUMBER">Numéro de licence</label>
            <input type="text" id="USER_LICENSENUMBER" name="USER_LICENSENUMBER" value="{{ old('USER_LICENSENUMBER') }}" >
            @error('USER_LICENSENUMBER')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Certificat médical !-->

        <div>
            <label for="USER_MEDICCERTIFICATEDATE">Date de Certificat Medical</label>
            <input type="date" id="USER_MEDICCERTIFICATEDATE" name="USER_MEDICCERTIFICATEDATE" value="{{ old('USER_MEDICCERTIFICATEDATE') }}" >
            @error('USER_MEDICCERTIFICATEDATE')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>


        <!-- Numéro Téléphone !-->

        <div>
            <label for="USER_PHONENUMBER">Numéro de téléphone</label>
            <input type="text" id="USER_PHONENUMBER" name="USER_PHONENUMBER" value="{{ old('USER_PHONENUMBER') }}" >
            @error('USER_PHONENUMBER')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Adresse !-->

        <div>
            <label for="USER_ADDRESS">Adresse</label>
            <input type="text" id="USER_ADDRESS" name="USER_ADDRESS" value="{{ old('USER_ADDRESS') }}" >
            @error('USER_ADDRESS')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>


        <!-- Niveau obtenu -->
        <div>
            <label for="LEVEL_ID">Level</label>
            <select name="LEVEL_ID" id="LEVEL_ID">
            </select>
            @error('LEVEL_ID')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Niveau préparé -->
        <div>
            <label for="LEVEL_ID_RESUME" id="LEVEL_ID_LABEL">Level préparé</label>
            <select name="LEVEL_ID_RESUME" id="LEVEL_ID_RESUME">
            </select>
            @error('LEVEL_ID_RESUME')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>


        <!-- Bouton d'inscription -->
        <div>
            <button type="submit">S'inscrire</button>
        </div>
    </form>

    <script src="/js/script.js"></script>

@endsection
