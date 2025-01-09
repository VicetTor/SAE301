@extends('Base')

@section('title', 'Formulaire | Formations')

@section('content')
<div class="container mt-5">
    <div class="card p-4 shadow-lg">
        <div class="card-body">
            <h1 class="text-center mb-4">Créer une formation</h1>
            <form action="{{ route('validate.forms1') }}" method="POST" onsubmit="return validateForm()">
                @csrf

                <!-- Niveau -->
                <div class="mb-3">
                    <label for="TRAIN_ID" class="form-label">Choix du niveau</label>
                    <select name="TRAIN_ID" id="TRAIN_ID" class="form-select">
                        <option value=""></option>
                        @foreach($trainDatas as $trainData)
                            <option value="{{$trainData->TRAIN_ID}}">{{'Niveau de formation' . ' ' . $trainData->TRAIN_ID}}</option>
                        @endforeach
                    </select>
                    @error('TRAIN_ID')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Responsable -->
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

                <!-- Message d'erreur -->
                <div id="error-message" class="text-danger mb-3" style="display: none;">
                    Le nombre d'étudiants sélectionnés dépasse le maximum autorisé en fonction du nombre d'initiateurs.
                </div>

                <!-- Bouton de validation -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg">
                        Valider
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Ajout d'un script pour gérer le dropdown au clic (Bootstrap 5)
    document.querySelectorAll('.dropdown-toggle').forEach(button => {
        button.addEventListener('click', function () {
            const dropdown = this.nextElementSibling;
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