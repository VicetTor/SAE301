@extends('Base')

@section('title', 'Sélectionner une année')

@section('content')

<h1 class="my-4">Sélectionner une année</h1>

<form action="{{ route('handleYearSelection') }}" method="POST">
    @csrf

    <!-- Sélection de l'année -->
    <div class="mb-3">
        <label for="year" class="form-label">Année</label>
        <select class="form-select" id="year" name="year" required>
            @foreach ($years as $year)
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>
    </div>

    <!-- Bouton de soumission -->
    <button type="submit" class="btn btn-primary">Exporter les données</button>
</form>

@endsection