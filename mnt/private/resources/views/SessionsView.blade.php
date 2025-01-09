@extends('Base')

@section('title', 'Toutes les sessions')

@section('content')
    <div>
        <p>Toutes les séances du niveau {{$sessions[0]->TRAIN_ID}} </p>
        @foreach ($sessions as $session)
            <div>
                <!-- Formulaire pour modifier la session -->
                <form action="{{ route('sessionsModifing', ['id' => $session->SESS_ID]) }}" method="GET" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">Modifier la séance du {{$session->SESS_DATE}}</button>
                </form>

                <!-- Formulaire pour supprimer la session -->
                <form action="{{ route('sessionsDelete', ['id' => $session->SESS_ID]) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE') <!-- Simuler une requête DELETE -->
                    <button type="submit" class="btn btn-danger">Supprimer la séance</button>
                </form>
            </div>
        @endforeach
    </div>
@endsection
