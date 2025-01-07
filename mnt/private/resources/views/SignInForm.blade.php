@extends('Base')

@section('title','a définir')
@section('navBarTitle', "Inscription")
@section('content')


    <form action="" method="POST">
        @csrf
        <div class = "range">
        <!-- Nom -->
            <div>
                <p>Nom</p>
                <input type="text" id="USER_LASTNAME" name="USER_LASTNAME" value="{{ old('USER_LASTNAME') }}" >
                @error('USER_LASTNAME')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>


        <!-- Prénom -->
            <div>
                <p>Prénom</p>
                <input type="text" id="USER_FIRSTNAME" name="USER_FIRSTNAME" value="{{ old('USER_FIRSTNAME') }}" >
                @error('USER_FIRSTNAME')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class = "range">
        <!-- Statut -->
            <div>
                <p>Statut</p>
                <select name="TYPE_ID" id="TYPE_ID">
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
                <p>Code Postal</p>
                <input type="text" id="USER_POSTALCODE" name="USER_POSTALCODE" value="{{ old('USER_POSTALCODE') }}" >
                @error('USER_POSTALCODE')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class = "range">
        <!-- Email -->
            <div>
                <p>Adresse e-mail</p>
                <input type="email" id="USER_MAIL" name="USER_MAIL" value="{{ old('USER_MAIL') }}" >
                @error('USER_MAIL')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>


            <!-- Date de Naissance -->

            <div>
                <p>Date de Naissance</p>
                <input type="date" id="USER_BIRTHDATE" name="USER_BIRTHDATE" value="{{ old('USER_BIRTHDATE') }}" >
                @error('USER_BIRTHDATE')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class = "range">
        <!-- Numéro de licence -->
            <div>
                <p>Numéro de licence</p>
                <input type="text" id="USER_LICENSENUMBER" name="USER_LICENSENUMBER" value="{{ old('USER_LICENSENUMBER') }}" >
                @error('USER_LICENSENUMBER')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Certificat médical !-->

            <div>
                <p>Date de Certificat Medical</p>
                <input type="date" id="USER_MEDICCERTIFICATEDATE" name="USER_MEDICCERTIFICATEDATE" value="{{ old('USER_MEDICCERTIFICATEDATE') }}" >
                @error('USER_MEDICCERTIFICATEDATE')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>


        <div class = "range">
        <!-- Numéro Téléphone !-->

            <div>
                <p>Numéro de téléphone</p>
                <input type="text" id="USER_PHONENUMBER" name="USER_PHONENUMBER" value="{{ old('USER_PHONENUMBER') }}" >
                @error('USER_PHONENUMBER')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Adresse !-->

            <div>
                <p>Adresse</p>
                <input type="text" id="USER_ADDRESS" name="USER_ADDRESS" value="{{ old('USER_ADDRESS') }}" >
                @error('USER_ADDRESS')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>


        <div class = "range">
        <!-- Niveau obtenu -->
            <div>
                <p>Level</p>
                <select name="LEVEL_ID" id="LEVEL_ID">
                    @foreach($levels as $level)
                        <option value="{{$level->LEVEL_ID}}">{{$level->LEVEL_LABEL}}</option>
                    @endforeach
                </select>
                @error('LEVEL_ID')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Niveau préparé -->
            <div>
                <p>Level préparé</p>
                <select name="LEVEL_ID_RESUME" id="LEVEL_ID_RESUME">
                    @foreach($levels as $level)
                        <option value="{{$level->LEVEL_ID}}">{{$level->LEVEL_LABEL}}</option>
                    @endforeach
                </select>
                @error('LEVEL_ID_RESUME')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>



        <!-- Bouton d'inscription -->
        <div class="range">
            <button type="submit" class="btn btn-outline-primary range">S'inscrire</button>
        </div>
    </form>
@endsection