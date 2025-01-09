@extends('Base')

@section('title', 'Sélectionner une année')

@section('content')

<h1 class="my-4">Sélectionner une année</h1>

<!-- Form to handle year selection -->
<form action="{{ route('handleYearSelection') }}" method="POST">
    @csrf

    <!-- Year selection dropdown -->
    <div class="mb-3">
        <label for="year" class="form-label">Année</label>
        <select class="form-select" id="year" name="year" required>
            <!-- Loop through the list of years and create options -->
            @foreach ($years as $year)
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>
    </div>

    <!-- Submit button to export the selected year data -->
    <button type="submit" class="btn btn-primary">Exporter les données</button>
</form>

@endsection
