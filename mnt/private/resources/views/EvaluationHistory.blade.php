@extends('Base') <!-- Extends the "Base" layout template -->

@section('title', 'Historique des évaluations') <!-- Sets the page title to "Evaluation History" -->

@section('content') <!-- Starts the content section that will be injected into the base layout -->

<h1 class="my-4">Historique des évaluations</h1> <!-- Heading for the page displaying evaluation history -->

<!-- Search Form -->
<form method="GET" action="{{ route('evaluations.search') }}" class="d-flex mb-4"> <!-- A GET form for searching evaluations -->
    <input type="text" name="search" class="form-control me-2" placeholder="Nom, Licence, Club, Niveau ou Compétence" value="{{ request()->get('search') }}"> <!-- Search input field where the user can type a search term -->
    <button type="submit" class="btn btn-primary">Rechercher</button> <!-- Submit button for the search form -->
</form>

<!-- Evaluations Table -->
<table class="table"> <!-- Table to display evaluation records -->
    <thead>
        <tr> <!-- Table header -->
            <th>Prénom</th> <!-- Column for First Name -->
            <th>Nom</th> <!-- Column for Last Name -->
            <th>Club</th> <!-- Column for Club -->
            <th>Date de Validation</th> <!-- Column for Validation Date -->
            <th>Niveau</th> <!-- Column for Level -->
            <th>Compétence</th> <!-- Column for Skill -->
            <th>Observation</th> <!-- Column for Observation -->
        </tr>
    </thead>
    <tbody>
        @foreach($evaluations as $evaluation) <!-- Iterates through all evaluations in the $evaluations variable -->
            <tr> <!-- Row for each evaluation -->
                <td>{{ $evaluation->user->USER_FIRSTNAME }}</td> <!-- Displays the user's first name -->
                <td>{{ $evaluation->user->USER_LASTNAME }}</td> <!-- Displays the user's last name -->
                <td>{{ optional($evaluation->user->reports->first()->club)->CLUB_NAME ?? 'Pas de club associé' }}</td> <!-- Displays the club name, or a default message if no club is associated -->
                <td>{{ $evaluation->validation->VALID_DATE ?? 'Pas de date de validation' }}</td> <!-- Displays the validation date, or a default message if none exists -->
                <td>{{ $evaluation->validation->level->LEVEL_LABEL ?? 'Pas de niveau associé' }}</td> <!-- Displays the evaluation level, or a default message if none exists -->
                <td>{{ $evaluation->validation->skill->SKILL_LABEL ?? 'Pas de compétence associée' }}</td> <!-- Displays the evaluation skill, or a default message if none exists -->
                <td>{{ $evaluation->EVAL_OBSERVATION ?? 'Pas d\'observation' }}</td> <!-- Displays the evaluation observation, or a default message if none exists -->
            </tr>
        @endforeach
    </tbody>
</table>

@endsection <!-- Ends the content section -->
