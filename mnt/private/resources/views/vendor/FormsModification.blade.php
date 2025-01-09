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

<h1>Modification d'une formation</h1>

<!-- Formulaire pour ajouter une formation -->
<form action="{{ route('validate.forms2') }}" method="POST">
    @csrf

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4>Ajouter une formation</h4>
        </div>

        <div class="card-body">
            <!-- Titre de la formation -->
            <div class="mb-3">
                <label for="SKILL_LABEL" class="form-label">Titre de la formation</label>
                <input type="text" id="SKILL_LABEL" name="SKILL_LABEL" class="form-control" value="{{ old('SKILL_LABEL') }}" required>
                @error('SKILL_LABEL')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Niveau de la formation -->
            <div class="mb-3">
                <label for="LEVEL_ID" class="form-label">Niveau</label>
                <select name="LEVEL_ID" id="LEVEL_ID" class="form-select" required>
                    <option value="">Sélectionner un niveau</option>
                    @foreach($levelIds as $levelId)
                        <option value="{{$levelId->LEVEL_ID}}" {{ old('LEVEL_ID') == $levelId->LEVEL_ID ? 'selected' : '' }}>{{$levelId->LEVEL_LABEL}}</option>
                    @endforeach
                </select>
                @error('LEVEL_ID')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Bouton de validation -->
        <div>
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </div>
</form>