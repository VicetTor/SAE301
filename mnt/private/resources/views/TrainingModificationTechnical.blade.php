@extends('Base')

@section('title', 'Modification formation')

@section('content')

<div class="container mt-5">
    <div class="card p-4 shadow-lg">
        <div class="card-body">
            <h1 class="text-center mb-4">Ajouter dans une formation</h1>
            <form action="" method="POST">
                @csrf

                <!-- Initiateurs -->
                <div class="form-group mb-3">
                    <label for="abilitie_id" class="form-label">Sélectionnez une aptitude :</label>
                    <select class="form-control" id="abilitie_id" name="abilitie_id">
                        @foreach($abilities as $abilitie)
                            <option value="{{$abilitie->ABI_ID}}">{{$abilitie->ABI_LABEL}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nouvelle aptitude -->
                <div class="form-group mb-3">
                    <label for="new_abilitie_id" class="form-label">Le nom que vous souhaitez donner à la nouvelle aptitude :</label>
                    <input type="text" class="form-control" id="new_abilitie_id" name="new_abilitie_id" placeholder="Entrez le nom de la nouvelle aptitude"/>
                </div>

                <!-- Bouton de validation -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check-circle"></i> Valider
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection