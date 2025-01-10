@extends('Base')
@section('title','Modification séance')
@section('navBarTitle', "Modification séance")
@section('content')


<!-- ligne 1 -->
<form action="" method="POST">
    @csrf
    <div class="range">
            <div>
                <p>Date</p>
                <input type="date" id="DATE" class="form-control" name="DATE" style="width:200px" >
                @error('DATE')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <p>Heure</p>
                <input type="time" class="form-control" name="time" style="width:200px" >
                @error('time')
                <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <p>Lieu</p>
                <select class="form-select" name="lieu" style="width:200px">
                    <option value="" disabled selected>Choix du lieu</option> <!-- Ne doit pas être choisi -->
                    <option value="Milieu Naturel" {{ old('lieu') == 'Milieu Naturel' ? 'selected' : '' }}>Milieu Naturel</option>
                    <option value="Piscine" {{ old('lieu') == 'Piscine' ? 'selected' : '' }}>Piscine</option>
                </select>
                    @error('lieu')
                    <span style="color: red;">{{ $message }}</span>
                    @enderror
            </div>
        </div>

    <!-- ligne 2 -->

    <div class="range">
        <div>
            <p>Elève</p>
            <select class="form-select" style="width:200px" name="user_id[]" >
                    <option value="-1">Choix de l'élève</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->USER_ID }}">
                            {{ $user->USER_FIRSTNAME }} {{ $user->USER_LASTNAME }}
                        </option>
                    @endforeach
            </select>
            @error('user_id.*')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
        <div>
        <p>Aptitude 1</p>
        <select class="form-select" style="width:200px" name="aptitude_id1[]" >
                    <option value="-1">Choix des aptitudes</option>
                    @foreach ($aptitudes as $label)
                        <option value="{{ $label->ABI_ID }}">{{ $label->Abi_label }}</option>
                    @endforeach
                </select>
            @error('aptitude_id1.*')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
        <div>
        <p>Aptitude 2</p>
        <select class="form-select" style="width:200px" name="aptitude_id2[]" >
                    <option value="-1">Choix des aptitudes</option>
                    @foreach ($aptitudes as $label)
                        <option value="{{ $label->ABI_ID }}">{{ $label->Abi_label }}</option>
                    @endforeach

                </select>
            @error('aptitude_id2.*')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
        <div>
        <p>Aptitude 3</p>
        <select class="form-select" style="width:200px" name="aptitude_id3[]" >
                    <option value="-1">Choix des aptitudes</option>
                    @foreach ($aptitudes as $label)
                        <option value="{{ $label->ABI_ID }}">{{ $label->Abi_label }}</option>
                    @endforeach

                </select>
            @error('aptitude_id3.*')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
        <div>
        <p>Initiateur</p>
        <select class="form-select" style="width:200px" name="initiator_id[]" >
                    <option selected>Choix de l'initiateur</option>
                    @foreach ($initiators as $initiator)
                        <option value="{{$initiator->USER_ID }}">{{ $initiator->USER_FIRSTNAME}} {{ $initiator->USER_LASTNAME }}</option>
                    @endforeach
                </select>
            @error('initiator_id.*')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
    </div>


    <!-- ligne 3  -->

    <div class="range">
        <div>
            <p>Elève</p>
            <select class="form-select" style="width:200px" name="user_id[]" >
                    <option value="-1">Choix de l'élève</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->USER_ID }}">
                            {{ $user->USER_FIRSTNAME }} {{ $user->USER_LASTNAME }}
                        </option>
                    @endforeach
                </select>
            @error('user_id.*')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
        <div>
        <p>Aptitude 1</p>
        <select class="form-select" style="width:200px" name="aptitude_id1[]" >
                    <option value="-1">Choix des aptitudes</option>
                    @foreach ($aptitudes as $label)
                        <option value="{{ $label->ABI_ID }}">{{ $label->Abi_label }}</option>
                    @endforeach
                </select>
            @error('aptitude_id1.*')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
        <div>
        <p>Aptitude 2</p>
        <select class="form-select" style="width:200px" name="aptitude_id2[]" >
                    <option value="-1">Choix des aptitudes</option>
                    @foreach ($aptitudes as $label)
                        <option value="{{ $label->ABI_ID }}">{{ $label->Abi_label }}</option>
                    @endforeach

                </select>
            @error('aptitude_id2.*')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
        <div>
        <p>Aptitude 3</p>
        <select class="form-select" style="width:200px" name="aptitude_id3[]" >
                    <option value="-1">Choix des aptitudes</option>
                    @foreach ($aptitudes as $label)
                        <option value="{{ $label->ABI_ID }}">{{ $label->Abi_label }}</option>
                    @endforeach

                </select>
            @error('aptitude_id3.*')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
        <div>
        <p>Initiateur</p>
        <select class="form-select" style="width:200px" name="initiator_id[]" >
                    <option selected>Choix de l'initiateur</option>
                    @foreach ($initiators as $initiator)
                        <option value="{{$initiator->USER_ID }}">{{ $initiator->USER_FIRSTNAME}} {{ $initiator->USER_LASTNAME }}</option>
                    @endforeach
                </select>
            @error('initiator_id.*')
            <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div id="addStudent">
            <!-- Les nouvelles lignes pour les élèves pour les séances apparaîtront ici -->
    </div>


    <div class="range">
        <div>
            <button type="button" class="btn btn-outline-warning range" id="button">Ajouter un élève</button>
        </div>
    </div>

    <div class="range">
        <div>
            <input type="text" placeholder="Information(s) complémentaire(s)" size=80px style="height: 70px; border-radius:20px; border-color:#005C8F;">
        </div>
    </div>

    <div class="range">
        <div>
            <button type="submit" class="btn btn-outline-danger">Retour</button>
        </div>
        <div>
            <button type="submit" class="btn btn-outline-primary">Valider</button>
        </div>
    </div>
    <script>
        // Récupérer les utilisateurs depuis Laravel et les transformer en JSON pour JavaScript
        var users = @json($users);
        console.log(users);  // Afficher la structure des données dans la console du navigateur
        var aptitudes = @json($aptitudes);
        var initiators = @json($initiators);
    </script>

    <script src="{{ asset('js/SessionCreate.js') }}"></script>
</form>


@endsection
