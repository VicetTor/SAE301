@extends('Base')

@section('title','Tableau Progression')

@section('content')


<?php

use App\Models\Ability;
use App\Models\Attendee;
use App\Models\Evaluation;
use App\Models\Skill;
use App\Models\StatusType;
use App\Models\User;

$user_id = session('user_id');

$level = session('level_id');
$skills = Skill::select('*')
    ->where('LEVEL_ID','=',$level)->get();
       
$skillsWithAbilities = [];
$i = 0;
foreach ($skills as $skill) {
    $abilities = Ability::select('*')
        ->where('SKILL_ID', '=', $skill->SKILL_ID)
            ->get();
    $skillsWithAbilities[$i] = $abilities;
    $i++;
}

$sessions = Attendee::select('*', 'GRP2_USER.*')
    ->join('GRP2_USER', 'GRP2_ATTENDEE.USER_ID_ATTENDEE', '=', 'GRP2_USER.USER_ID')
        ->join('GRP2_SESSION', 'GRP2_SESSION.SESS_ID', '=', 'GRP2_ATTENDEE.SESS_ID')
            ->where('GRP2_USER.USER_ID', '=', $user_id)
                ->get();    
$evaluationsChaqueSeance =[];
$i = 0;
foreach($sessions as $session){
    $evaluations = Evaluation::select('*')
        ->join('GRP2_STATUSTYPE', 'GRP2_STATUSTYPE.STATUSTYPE_ID', '=', 'GRP2_EVALUATION.STATUSTYPE_ID')
            ->join('GRP2_SESSION', 'GRP2_SESSION.SESS_ID', '=', 'GRP2_EVALUATION.SESS_ID')
                ->where('GRP2_EVALUATION.SESS_ID', '=', $session->SESS_ID)
                    ->get();
    $evaluationsChaqueSeance[$i] = $evaluations;
    $i++;
}

$statustype = StatusType::select('*')->get();
$eleves = User::select('*')
    ->where('TYPE_ID', '=', 1)
        ->get();

?>


@if(session('type_id') != 3)
    <h1>Vous n'avez les droits nécéssaires</h1>
    <script>
        window.stop();
    </script>
@endif

<p class="fw-medium fs-3"> Vous êtes connecté(e) en tant que : {{ session('user_firstname') }} {{ session('user_lastname') }} </p>

<div class="form-floating">
  <select class="form-select" id="selectEleve" aria-label="Floating label select example">
    <option selected>Sélectionner un élève ici</option>
    @foreach($eleves as $eleve)
        <option value="{{ $eleve->USER_ID }}">
            {{$eleve->USER_FIRSTNAME}} {{$eleve->USER_LASTNAME}} {{$eleve->USER_ID}}
        </option>
    @endforeach
  </select>
</div>

<p class="fst-italic fs-5" id="result">Merci de bien vouloir choisir un(e) élève </p>

        <table id=tabletable>

        </table>
        
            
        
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
$(document).on('change', '#selectEleve', function() {
    var userId = $(this).val();
    var selectedEleve = $(this).find("option:selected").text();

    $('#result').text("Tableau évolutif de : " + selectedEleve);

    $.ajax({
        url: '/choixEleve',
        type: 'GET',
        data: { user_id: userId },
        success: function(response) {
            $('#tabletable').html(response.html);
        },
        error: function() {
            alert('Une erreur est survenue.');
        }
    });

    $(document).on('change', '.scroll', function() {
        var evalId = $(this).data('eval-id');
        var statutId = $(this).val();
        var userId = $(this).data('user-id');
        var abiId = $(this).data('abi-id');
        var sessId = $(this).data('sess-id');

    $.ajax({
        url: '/updateEvaluation',
        type: 'POST',
        data: {
            eval_id: evalId,
            statut_id: statutId,
            user_id: userId,
            abi_id: abiId,
            sess_id: sessId,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
        },
        error: function() {
        }
    });
});


    


});




    </script>


</body>
    </tbody>
    </table>

    <style>
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-family: Arial, sans-serif;
}

th, td {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
    font-size: 14px;
}

th {
    background-color: #f2f2f2;
    text-align: center;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

td.date-cell {
    text-align: left;
    width: 15%;
}

td.skill-cell {
    text-align: center;
    width: 20%;
}

td.ability-cell {
    text-align: center;
    width: 15%;
}

td.select-cell select {
    width: 100%;
    padding: 5px;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    table {
        width: 100%;
        font-size: 12px;
    }
    
    td, th {
        padding: 8px;
    }
}

    </style>
    
@endsection
