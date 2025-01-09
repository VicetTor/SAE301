@extends('Base')

@section('title', 'Toutes les sessions')

@section('content')
    <div>
        <p>Toutes les sessions</p>
        @foreach ($sessions as $session)
            <!-- Formulaire pour chaque session avec un bouton -->
            <form action="{{ route('sessionsModifing', ['id' => $session->id]) }}" method="GET">
                @csrf <!-- CSRF protection, bien que pour GET, cela ne soit pas strictement nécessaire -->
                <button type="submit" class="btn btn-primary">Modifier la séance du {{$session->SESS_DATE}}</button>
            </form>
        @endforeach
    </div>
@endsection
