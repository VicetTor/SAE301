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
                <td>
                    @if($evaluation->club)
                        {{ $evaluation->club->CLUB_NAME }}
                    @else
                        Pas de club associé
                    @endif
                </td>
                <td>
                    @if($evaluation->validation_date)
                        {{ $evaluation->validation_date }}
                    @else
                        Pas de date de validation
                    @endif
                </td>
                <td>{{ $evaluation->LEVEL_ID }}</td>
                <td>
                    @if($evaluation->level)
                        {{ $evaluation->level->LEVEL_LABEL }}
                    @else
                        Pas de niveau associé
                    @endif
                <td>
                    @if($evaluation->skill)
                        {{ $evaluation->skill->Skill_Label }}
                    @else
                        Pas de compétence associée
                    @endif
                </td>
                <td>
                    @if($evaluation->observation)
                        {{ $evaluation->observation }}
                    @else
                        Pas d'observation
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
