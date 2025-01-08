@extends('Base')
@section('title','Création séance')
@section('navBarTitle', "Création d'une séance")
@section('content')


<!-- ligne 1 -->
<form action="" method="POST">
    @csrf
    <div class="range">
            <div>
                <p>Date</p>
                <input type="date" class="form-control" name="date" style="width:200px" required>
            </div>
            <div>
                <p>Heure</p>
                <input type="time" class="form-control" name="time" style="width:200px" required>
            </div>
            <div>
                <p>Lieu</p>
                <select class="form-select" name="lieu" style="width:200px" required>
                    <option selected>Choix du lieu</option>
                    <option value="Milieu Naturel">Milieu Naturel</option>
                    <option value="Piscine">Piscine</option>
                </select>
            </div>
        </div>
        
    <!-- ligne 2 -->

    <div class="range">
        <div> 
            <p>Elève</p>
            <select class="form-select" style="width:200px" name="user_id" required>
                    <option selected>Choix de l'élève</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->USER_ID }}">
                            {{ $user->USER_FIRSTNAME }} {{ $user->USER_LASTNAME }}
                        </option>
                    @endforeach
                </select>
        </div>
        <div> 
        <p>Aptitude 1</p>
        <select class="form-select" style="width:200px" name="aptitude_id" required>
                    <option selected>Choix des aptitudes</option>
                    @foreach ($aptitudes as $label)
                        <option value="{{ $label->Abi_label }}">{{ $label->Abi_label }}</option>
                    @endforeach

                </select>
        </div>
        <div> 
        <p>Aptitude 2</p>
        <select class="form-select" style="width:200px" name="aptitude_id" required>
                    <option selected>Choix des aptitudes</option>
                    @foreach ($aptitudes as $label)
                        <option value="{{ $label->Abi_label }}">{{ $label->Abi_label }}</option>
                    @endforeach

                </select>
        </div>
        <div> 
        <p>Aptitude 3</p>
        <select class="form-select" style="width:200px" name="aptitude_id" required>
                    <option selected>Choix des aptitudes</option>
                    @foreach ($aptitudes as $label)
                        <option value="{{ $label->Abi_label }}">{{ $label->Abi_label }}</option>
                    @endforeach

                </select>
        </div>
        <div> 
        <p>Initiateur</p>
        <select class="form-select" style="width:200px" name="initiator_id" required>
                    <option selected>Choix de l'initiateur</option>
                    @foreach ($initiators as $id => $name)
                        <option value="{{ $id }}">{{ $name->USER_FIRSTNAME}} {{ $name->USER_LASTNAME }}</option>
                    @endforeach
                </select>
        </div>
    </div> 

    
    <!-- ligne 3  -->

    <div class="range">
        <div> 
            <p>Elève</p>
            <select class="form-select" style="width:200px" name="user_id" required>
                    <option selected>Choix de l'élève</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->USER_ID }}">
                            {{ $user->USER_FIRSTNAME }} {{ $user->USER_LASTNAME }}
                        </option>
                    @endforeach
                </select>
        </div>
        <div> 
        <p>Aptitude 1</p>
        <select class="form-select" style="width:200px" name="aptitude_id" required>
                    <option selected>Choix des aptitudes</option>
                    @foreach ($aptitudes as $label)
                        <option value="{{ $label->ABI_ID }}">{{ $label->Abi_label }}</option>
                    @endforeach

                </select>
        </div>
        <div> 
        <p>Aptitude 2</p>
        <select class="form-select" style="width:200px" name="aptitude_id" required>
                    <option selected>Choix des aptitudes</option>
                    @foreach ($aptitudes as $label)
                        <option value="{{ $label->ABI_ID }}">{{ $label->Abi_label }}</option>
                    @endforeach

                </select>
        </div>
        <div> 
        <p>Aptitude 3</p>
        <select class="form-select" style="width:200px" name="aptitude_id" required>
                    <option selected>Choix des aptitudes</option>
                    @foreach ($aptitudes as $label)
                        <option value="{{ $label->ABI_ID }}">{{ $label->Abi_label }}</option>
                    @endforeach

                </select>
        </div>
        <div> 
        <p>Initiateur</p>
        <select class="form-select" style="width:200px" name="initiator_id" required>
                    <option selected>Choix de l'initiateur</option>
                    @foreach ($initiators as $id => $name)
                        <option value="{{ $id }}">{{ $name->USER_FIRSTNAME}} {{ $name->USER_LASTNAME }}</option>
                    @endforeach
                </select>
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
