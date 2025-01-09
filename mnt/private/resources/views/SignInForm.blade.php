@extends('Base')

@section('title','Inscription')
@section('navBarTitle', "Inscription")
@section('content')


    <form action="" method="POST">
        @csrf
    <div class="test">
        <!-- Nom -->
        <div class = "rowRegistration">
            <div>
                <p>Nom</p>
                <input type="text" id="USER_LASTNAME" name="USER_LASTNAME" value="{{ old('USER_LASTNAME') }}" >
                <br>
                @error('USER_LASTNAME')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Prénom -->
        <div class = "secondColumn">
            <div>
                <p>Prénom</p>
                <input type="text" id="USER_FIRSTNAME" name="USER_FIRSTNAME" value="{{ old('USER_FIRSTNAME') }}" >
                <br>
                @error('USER_FIRSTNAME')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Statut -->
        <div class = "thirdColumn">
            <div>
                <p>Statut</p>
                <select name="TYPE_ID" id="TYPE_ID">
                    @foreach($typeUser as $user)
                        @if($user->TYPE_ID != 2)
                        <option value="{{$user->TYPE_ID}}">{{$user->TYPE_LABEL}}</option>
                        @endif
                    @endforeach
                </select>
                <br>
                @error('TYPE_ID')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>


    <div class="test">

        <!-- Adresse postale !-->
        <div class = "rowRegistration">
            <div>
                <p>Adresse postale</p>
                <input type="text" id="USER_ADDRESS" name="USER_ADDRESS" value="{{ old('USER_ADDRESS') }}" >
                <br>
                @error('USER_ADDRESS')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Code Postal -->
        <div class = "secondColumn">
            <div>
                <p>Code Postal</p>
                <input type="text" id="USER_POSTALCODE" name="USER_POSTALCODE" value="{{ old('USER_POSTALCODE') }}" >
                <br>
                @error('USER_POSTALCODE')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Date de Naissance -->

        <div class = "thirdColumn">
            <div>
                <p>Date de Naissance</p>
                <input type="date" id="USER_BIRTHDATE" name="USER_BIRTHDATE" value="{{ old('USER_BIRTHDATE') }}" >
                <br>
                @error('USER_BIRTHDATE')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>



    <div class="test">
        <!-- Email -->
        <div class = "rowRegistration">
            <div>
                <p>Adresse e-mail</p>
                <input type="email" id="USER_MAIL" name="USER_MAIL" value="{{ old('USER_MAIL') }}" >
                <br>
                @error('USER_MAIL')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Numéro Téléphone !-->
        <div class = "secondColumn">
            <div>
                <p>Numéro de téléphone</p>
                <input type="text" id="USER_PHONENUMBER" name="USER_PHONENUMBER" value="{{ old('USER_PHONENUMBER') }}" >
                <br>
                @error('USER_PHONENUMBER')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Certificat médical !-->
        <div class = "thirdColumn">
            <div>
                <p>Date de Certificat Medical</p>
                <input type="date" id="USER_MEDICCERTIFICATEDATE" name="USER_MEDICCERTIFICATEDATE" value="{{ old('USER_MEDICCERTIFICATEDATE') }}" >
                <br>
                @error('USER_MEDICCERTIFICATEDATE')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>



    <div class="test">
        <!-- Numéro de licence -->
        <div class = "rowRegistration">
            <div>
                <p>Numéro de licence</p>
                <input type="text" id="USER_LICENSENUMBER" name="USER_LICENSENUMBER" value="{{ old('USER_LICENSENUMBER') }}" >
                <br>
                @error('USER_LICENSENUMBER')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Niveau obtenu -->
        <div class = "secondColumn">
            <div>
                <p>Niveau</p>
                <select name="LEVEL_ID" id="LEVEL_ID">
                    @foreach($levels as $level)
                        <option value="{{$level->LEVEL_ID}}">{{$level->LEVEL_LABEL}}</option>
                    @endforeach
                </select>
                <br>
                @error('LEVEL_ID')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Niveau préparé -->
        <div class = "thirdColumn">
            <div>
                <p>Niveau préparé</p>
                <select name="LEVEL_ID_RESUME" id="LEVEL_ID_RESUME">
                    @foreach($levels as $level)
                        <option value="{{$level->LEVEL_ID}}">{{$level->LEVEL_LABEL}}</option>
                    @endforeach
                </select>
                <br>
                @error('LEVEL_ID_RESUME')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

        <!-- Bouton d'inscription -->
        <div class="range">
            <button type="submit" class="btn btn-outline-primary range">S'inscrire</button>
        </div>
    </form>

    <script src="/js/script.js"></script>
@endsection
