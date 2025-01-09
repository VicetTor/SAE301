@extends('Base')

@section('title','a définir')

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
    ->join('GRP2_USER', 'GRP2_ATTENDEE.USER_ID', '=', 'GRP2_USER.USER_ID')
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
    ->where('TYPE_ID', '=', 4)
    ->get();

    ?>





        <p> Bonjour {{ session('user_firstname') }} {{ session('user_lastname') }} </p>
        <p> Vous etes niveau {{ session('level_id') }}

        <select id="selectEleve">
            <option value="" disabled selected>Sélectionner un élève</option>
            @foreach($eleves as $eleve)
                <option value="{{ $eleve->USER_ID }}">
                    {{$eleve->USER_FIRSTNAME}} {{$eleve->USER_LASTNAME}}
                </option>
            @endforeach
        </select>

        <h1 id="result">Tableau évolutif des étudiants</h1>

        <table id=tabletable>

        </table>
        
            
        
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
       $(document).ready(function() {
        $(document).on('change', '#selectEleve', function() {
        var userId = $(this).val();
        var selectedEleve = $(this).find("option:selected").text(); // Récupère le texte de l'option sélectionnée

        // Met à jour le texte du <h1> avec l'information de l'élève
        $('#result').text("Tableau évolutif de : " + selectedEleve);

        $.ajax({
            url: '/choixEleve',
            type: 'GET',
            data: { user_id: userId },
            success: function(response) {
                $('#tabletable').replaceWith(response.html);
            },
            error: function() {
                alert('Une erreur est survenue.');
            }
        });
    });

    $(document).on('change', '.scroll', function() {
        var evalId = $(this).data('eval-id');
        var selectedStatus = $(this).val();
        var user_id = $(this).data('user-id');
        var abi_id = $(this).data('abi-id');
        var sess_id = $(this).data('sess-id');

        if (evalId) console.log(evalId);

        if (selectedStatus) {
            $.ajax({
                url: '/updateEvaluation',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    eval_id: evalId,
                    statut_id: selectedStatus,
                    user_id: user_id,
                    abi_id: abi_id,
                    sess_id: sess_id
                },
                success: function(response) {
                },
                error: function() {
                    alert('Une erreur est survenue lors de la mise à jour.');
                }
            });
        }
    });
});



    </script>


</body>
    </tbody>
    </table>

    <!-- Vous pouvez supprimer ce css cetait juste pour etre lisible en attendant !-->
    <style>
        /* Global table style */
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

/* Style for the headers */
th {
    background-color: #f2f2f2;
    text-align: center;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Ensuring proper alignment of the session date (on the left) */
td.date-cell {
    text-align: left;
    width: 15%;
}

/* Ensuring that skills are neatly organized in their columns */
td.skill-cell {
    text-align: center;
    width: 20%;
}

/* Ability cells should be centered */
td.ability-cell {
    text-align: center;
    width: 15%;
}

/* Select dropdown for the evaluations should have a smaller size */
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
