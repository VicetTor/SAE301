@extends('Base')

@section('title', 'Formulaire | Formations')

@section('content')
<style>
    /* Style for the dropdown section */
    .dropdown {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    /* Style for the dropdown buttons */
    .dropdown button {
        padding: 10px;
        font-size: 16px;
        cursor: pointer;
        width: 100%;
        text-align: left;
    }

    /* Dropdown content containing checkboxes */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 300px; /* Minimum width of the list */
        border: 1px solid #ccc;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
        max-height: 200px;
        overflow-y: auto;
        padding: 10px;
    }

    /* Show the dropdown content on hover or click */
    .dropdown:hover .dropdown-content, .dropdown.show .dropdown-content {
        display: block;
    }

    /* Style for each checkbox line and label */
    .checkbox-container {
        display: block; /* Stack the elements vertically */
        padding: 8px;
        cursor: pointer;
    }

    .checkbox-container label {
        font-size: 16px;
        margin-left: 8px;
    }

    .checkbox-container input[type="checkbox"] {
        margin-right: 8px;
        transform: scale(1.5); /* Enlarge the checkboxes */
    }

    /* Error message style */
    .error-message {
        color: red;
        display: none;
    }
</style>

<h1>Créer une formation</h1>

<!-- Form for selecting responsible, initiators, and students -->
<form action="{{ route('validate.forms1') }}" method="POST" onsubmit="return validateForm()">
    @csrf

    <!-- Responsable selection -->
    <div class="mb-3">
        <label for="TRAIN_RESPONSABLE_ID" class="form-label">Choix responsable</label>
        <select name="TRAIN_RESPONSABLE_ID" id="TRAIN_RESPONSABLE_ID" class="form-select">
            <option value=""></option>
            @foreach($trainings as $training)
                <option value="{{$training->USER_ID}}">{{$training->USER_FIRSTNAME . ' ' .$training->USER_LASTNAME}}</option>
            @endforeach
        </select>
        @error('TRAIN_RESPONSABLE_ID')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Level selection -->
    <div class="mb-3">
        <label for="TRAIN_ID" class="form-label">Choix du niveau</label>
        <select name="TRAIN_ID" id="TRAIN_ID" class="form-select">
            <option value=""></option>
            @foreach($trainDatas as $trainData)
                <option value="{{$trainData->TRAIN_ID}}">{{$trainData->TRAIN_ID}}</option>
            @endforeach
        </select>
        @error('TRAIN_ID')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Initiators selection with dropdown -->
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

    <!-- Students selection with dropdown -->
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

    <!-- Error message for exceeding student limit -->
    <div class="error-message" id="error-message">
        Le nombre d'étudiants sélectionnés dépasse le maximum autorisé en fonction du nombre d'initiateurs.
    </div>

    <!-- Submit button -->
    <div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </div>
</form>

@endsection

@push('scripts')
<script>
    // Add a script to manage the dropdown behavior on click (Bootstrap 5)
    document.querySelectorAll('.dropdown button').forEach(button => {
        button.addEventListener('click', function () {
            const dropdown = this.parentElement;
            dropdown.classList.toggle('show'); // Toggle 'show' class to display/hide the list
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

    // Form validation function
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
