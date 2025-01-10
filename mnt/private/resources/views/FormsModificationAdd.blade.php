@extends('Base')

@section('title', 'Formulaire | Formations')

@section('content')
<style>
    /* Style pour la section de dropdown */
    .dropdown {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    /* Styles pour les boutons dropdown */
    .dropdown button {
        padding: 10px;
        font-size: 16px;
        cursor: pointer;
        width: 100%;
        text-align: left;
    }

    /* Liste déroulante contenant les checkboxes */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 300px; /* Largeur minimale de la liste */
        border: 1px solid #ccc;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
        max-height: 200px;
        overflow-y: auto;
        padding: 10px;
    }

    /* Afficher la liste déroulante au survol ou au clic */
    .dropdown:hover .dropdown-content, .dropdown.show .dropdown-content {
        display: block;
    }

    /* Style pour chaque ligne de checkbox et label */
    .checkbox-container {
        display: block; /* Empile les éléments verticalement */
        padding: 8px;
        cursor: pointer;
    }

    .checkbox-container label {
        font-size: 16px;
        margin-left: 8px;
    }

    .checkbox-container input[type="checkbox"] {
        margin-right: 8px;
        transform: scale(1.5); /* Agrandir la taille des checkboxes */
    }

    .error-message {
        color: red;
        display: none;
    }
</style>

<h1>Ajouter dans une formation</h1>
<form action="" method="POST" onsubmit="return validateForm()">
    @csrf

    <!-- Initiateurs -->
    <div class="dropdown mb-3">
        <button class="btn btn-secondary w-100" type="button" id="initiatorDropdown" aria-expanded="false">
            Choisissez vos initiateurs
        </button>
        <div class="dropdown-content" aria-labelledby="initiatorDropdown">
            @foreach($trainings as $training)
            <div class="checkbox-container">
                <input type="checkbox" id="initiator{{$training->USER_ID}}" name="initiators[]" value="{{$training->USER_ID}}" onclick="checkMaxStudents()">
                <label for="initiator{{$training->USER_ID}}">{{$training->USER_FIRSTNAME . ' ' .$training->USER_LASTNAME}}</label>
            </div>
            @endforeach
        </div>
        @error('initiators')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Élèves -->
    <div class="dropdown mb-3">
        <button class="btn btn-secondary w-100" type="button" id="studentDropdown" aria-expanded="false">
            Choisissez vos élèves
        </button>
        <div class="dropdown-content" aria-labelledby="studentDropdown">
            @foreach($studies as $studie)
            <div class="checkbox-container">
                <input type="checkbox" id="student{{$studie->USER_ID}}" name="students[]" value="{{$studie->USER_ID}}" onclick="checkMaxStudents()">
                <label for="student{{$studie->USER_ID}}">{{$studie->USER_FIRSTNAME . ' ' .$studie->USER_LASTNAME}}</label>
            </div>
            @endforeach
        </div>
        @error('students')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Bouton de validation -->
    <div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </div>
</form>

@endsection

@push('scripts')
<script>
    // Ajout d'un script pour gérer le dropdown au clic (Bootstrap 5)
    document.querySelectorAll('.dropdown button').forEach(button => {
        button.addEventListener('click', function () {
            const dropdown = this.parentElement;
            dropdown.classList.toggle('show'); // Bascule la classe 'show' pour afficher/masquer la liste
        });
    });

    function checkMaxStudents() {
        const initiators = document.querySelectorAll('input[name="initiators[]"]:checked').length;
        const students = document.querySelectorAll('input[name="students[]"]:checked').length;
        const maxStudents = initiators * 2;

        const errorMessage = document.getElementById('error-message');
        if (students > maxStudents) {
            errorMessage.style.display = 'block';
        } else {
            errorMessage.style.display = 'none';
        }
    }

    function validateForm() {
        const initiators = document.querySelectorAll('input[name="initiators[]"]:checked').length;
        const students = document.querySelectorAll('input[name="students[]"]:checked').length;
        const maxStudents = initiators * 2;

        if (students > maxStudents) {
            alert('Le nombre d\'étudiants sélectionnés dépasse le maximum autorisé en fonction du nombre d\'initiateurs.');
            return false;
        }
        return true;
    }
</script>
@endpush
