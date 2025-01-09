@extends('Base')

@section('title','Inscription')
@section('navBarTitle', "Inscription")
@section('content')

    <!-- Form to handle user registration -->
    <form action="" method="POST">
        @csrf
    <div class="test">
        <!-- Last Name -->
        <div class = "rowRegistration">
            <div>
                <p>Nom</p> <!-- French: Last Name -->
                <input type="text" id="USER_LASTNAME" name="USER_LASTNAME" value="{{ old('USER_LASTNAME') }}" >
                <br>
                <!-- Display error message if there's an issue with 'USER_LASTNAME' input -->
                @error('USER_LASTNAME')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- First Name -->
        <div class = "secondColumn">
            <div>
                <p>Prénom</p> <!-- French: First Name -->
                <input type="text" id="USER_FIRSTNAME" name="USER_FIRSTNAME" value="{{ old('USER_FIRSTNAME') }}" >
                <br>
                <!-- Display error message if there's an issue with 'USER_FIRSTNAME' input -->
                @error('USER_FIRSTNAME')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Status (User type) -->
        <div class = "thirdColumn">
            <div>
                <p>Statut</p> <!-- French: Status -->
                <select name="TYPE_ID" id="TYPE_ID">
                    @foreach($typeUser as $user)
                        @if($user->TYPE_ID != 2)
                        <option value="{{$user->TYPE_ID}}">{{$user->TYPE_LABEL}}</option> <!-- Display user type options -->
                        @endif
                    @endforeach
                </select>
                <br>
                <!-- Display error message if there's an issue with 'TYPE_ID' input -->
                @error('TYPE_ID')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="test">
        <!-- Postal Address -->
        <div class = "rowRegistration">
            <div>
                <p>Adresse postale</p> <!-- French: Postal Address -->
                <input type="text" id="USER_ADDRESS" name="USER_ADDRESS" value="{{ old('USER_ADDRESS') }}" >
                <br>
                <!-- Display error message if there's an issue with 'USER_ADDRESS' input -->
                @error('USER_ADDRESS')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Postal Code -->
        <div class = "secondColumn">
            <div>
                <p>Code Postal</p> <!-- French: Postal Code -->
                <input type="text" id="USER_POSTALCODE" name="USER_POSTALCODE" value="{{ old('USER_POSTALCODE') }}" >
                <br>
                <!-- Display error message if there's an issue with 'USER_POSTALCODE' input -->
                @error('USER_POSTALCODE')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Date of Birth -->
        <div class = "thirdColumn">
            <div>
                <p>Date de Naissance</p> <!-- French: Date of Birth -->
                <input type="date" id="USER_BIRTHDATE" name="USER_BIRTHDATE" value="{{ old('USER_BIRTHDATE') }}" >
                <br>
                <!-- Display error message if there's an issue with 'USER_BIRTHDATE' input -->
                @error('USER_BIRTHDATE')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="test">
        <!-- Email Address -->
        <div class = "rowRegistration">
            <div>
                <p>Adresse e-mail</p> <!-- French: Email Address -->
                <input type="email" id="USER_MAIL" name="USER_MAIL" value="{{ old('USER_MAIL') }}" >
                <br>
                <!-- Display error message if there's an issue with 'USER_MAIL' input -->
                @error('USER_MAIL')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Phone Number -->
        <div class = "secondColumn">
            <div>
                <p>Numéro de téléphone</p> <!-- French: Phone Number -->
                <input type="text" id="USER_PHONENUMBER" name="USER_PHONENUMBER" value="{{ old('USER_PHONENUMBER') }}" >
                <br>
                <!-- Display error message if there's an issue with 'USER_PHONENUMBER' input -->
                @error('USER_PHONENUMBER')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Medical Certificate Date -->
        <div class = "thirdColumn">
            <div>
                <p>Date de Certificat Médical</p> <!-- French: Medical Certificate Date -->
                <input type="date" id="USER_MEDICCERTIFICATEDATE" name="USER_MEDICCERTIFICATEDATE" value="{{ old('USER_MEDICCERTIFICATEDATE') }}" >
                <br>
                <!-- Display error message if there's an issue with 'USER_MEDICCERTIFICATEDATE' input -->
                @error('USER_MEDICCERTIFICATEDATE')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="test">
        <!-- License Number -->
        <div class = "rowRegistration">
            <div>
                <p>Numéro de licence</p> <!-- French: License Number -->
                <input type="text" id="USER_LICENSENUMBER" name="USER_LICENSENUMBER" value="{{ old('USER_LICENSENUMBER') }}" >
                <br>
                <!-- Display error message if there's an issue with 'USER_LICENSENUMBER' input -->
                @error('USER_LICENSENUMBER')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Level Obtained -->
        <div class = "secondColumn">
            <div>
                <p>Niveau</p> <!-- French: Level Obtained -->
                <select name="LEVEL_ID" id="LEVEL_ID">
                    @foreach($levels as $level)
                        <option value="{{$level->LEVEL_ID}}">{{$level->LEVEL_LABEL}}</option> <!-- Display available levels -->
                    @endforeach
                </select>
                <br>
                <!-- Display error message if there's an issue with 'LEVEL_ID' input -->
                @error('LEVEL_ID')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Level Prepared -->
        <div class = "thirdColumn">
            <div>
                <p id="LEVEL_ID_LABEL">Niveau préparé</p> <!-- French: Level Prepared -->
                <select name="LEVEL_ID_RESUME" id="LEVEL_ID_RESUME">
                    @foreach($levels as $level)
                        <option value="{{$level->LEVEL_ID}}">{{$level->LEVEL_LABEL}}</option> <!-- Display available levels -->
                    @endforeach
                </select>
                <br>
                <!-- Display error message if there's an issue with 'LEVEL_ID_RESUME' input -->
                @error('LEVEL_ID_RESUME')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="range">
        <button type="submit" class="btn btn-outline-primary range">S'inscrire</button> <!-- French: Register -->
    </div>
    </form>

    <!-- Link to external script file -->
    <script src="/js/script.js"></script>
@endsection
