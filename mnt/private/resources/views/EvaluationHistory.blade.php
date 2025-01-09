@extends('Base')

@section('title', 'Historique des évaluations')

@section('content')

<h1 class="my-4">Historique des évaluations</h1>

<!-- Formulaire de recherche -->
<form method="GET" action="{{ route('evaluations.search') }}" class="d-flex mb-4">
    <input type="text" name="search" class="form-control me-2" placeholder="Nom, Licence, Club, Niveau ou Compétence" value="{{ request()->get('search') }}">
    <button type="submit" class="btn btn-primary">Rechercher</button>
</form>

<!-- Tableau des évaluations -->
<table class="table">
    <thead>
        <tr>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Club</th>
            <th>Date de Validation</th>
            <th>Niveau</th>
            <th>Compétence</th>
            <th>Observation</th>
        </tr>
    </thead>
    <tbody>
        @foreach($evaluations as $evaluation)
            <tr>
                <td>{{ $evaluation->user->USER_FIRSTNAME }}</td>
                <td>{{ $evaluation->user->USER_LASTNAME }}</td>
                <td>{{ optional($evaluation->user->reports->first()->club)->CLUB_NAME ?? 'Pas de club associé' }}</td>
                <td>{{ $evaluation->validation->VALID_DATE ?? 'Pas de date de validation' }}</td>
                <td>{{ $evaluation->validation->level->LEVEL_LABEL ?? 'Pas de niveau associé' }}</td>
                <td>{{ $evaluation->validation->skill->SKILL_LABEL ?? 'Pas de compétence associée' }}</td>
                <td>{{ $evaluation->EVAL_OBSERVATION ?? 'Pas d\'observation' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection