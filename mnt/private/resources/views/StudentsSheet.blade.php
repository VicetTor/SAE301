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
use App\Models\Session;


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

$sessions = Attendee::select('*', 'grp2_user.*')
    ->join('grp2_user', 'grp2_attendee.USER_ID_ATTENDEE', '=', 'grp2_user.USER_ID')
        ->join('grp2_session', 'grp2_session.SESS_ID', '=', 'grp2_attendee.SESS_ID')
            ->where('grp2_user.USER_ID', '=', $user_id)
                ->get();    
$evaluationsChaqueSeance =[];
$i = 0;
foreach($sessions as $session){
    $evaluations = Evaluation::select('*')
        ->join('grp2_statustype', 'grp2_statustype.STATUSTYPE_ID', '=', 'grp2_evaluation.STATUSTYPE_ID')
            ->join('grp2_session', 'grp2_session.SESS_ID', '=', 'grp2_evaluation.SESS_ID')
                ->where('grp2_evaluation.SESS_ID', '=', $session->SESS_ID)
                    ->get();
    $evaluationsChaqueSeance[$i] = $evaluations;
    $i++;
}

$statustype = StatusType::select('*')->get();

$attendee = Attendee::select('USER_ID_ATTENDEE')
->where('USER_ID', '=', Session('user_id'))
->distinct()
->get();

?>
{{$attendee}}


@if(!(Session('type_id') == 3) && !(Session('type_id') == 2))
    <h1>Vous n'avez les droits nécessaires</h1>
    <script>
        window.stop();
    </script>
@endif


<p class="fw-medium fs-3"> Vous êtes connecté(e) en tant que : {{ session('user_firstname') }} {{ session('user_lastname') }} </p>

<div class="form-floating">
  <select class="form-select" id="selectEleve" aria-label="Floating label select example">
    <option selected>Sélectionner un élève ici</option>

        
            @if(Session('type_id') == 2)
            salut
                @foreach($attendee as $att)
                    @php
                        $eleves = App\Models\User::where('TYPE_ID', 1)
                            ->where('USER_ID', $att->USER_ID_ATTENDEE)
                            ->distinct()
                            ->get();
                    @endphp
                
                    @foreach($eleves as $eleve)
                        <option value="{{ $eleve->USER_ID }}">
                            {{ $eleve->USER_FIRSTNAME }} {{$eleve->USER_LASTNAME}}
                        </option>
                    @endforeach
                @endforeach
                @elseif(session('type_id') == 3)
                @php
                $eleves = App\Models\User::where('TYPE_ID', 1)->get();
                @endphp

                @foreach($eleves as $eleve)
                    <option value="{{ $eleve->USER_ID }}">
                        {{ $eleve->USER_FIRSTNAME }} {{$eleve->USER_LASTNAME}}
                    </option>
                @endforeach
                @endif
            
        
  </select>
</div>

<p class="fst-italic fs-5" id="result">Merci de bien vouloir choisir un(e) élève </p>

        <table id=tabletable>

        </table>

<div id="popup" class="popup-overlay" style="display: none;">
    <div class="popup-content">
        <span class="popup-close">&times;</span>
        <h3>Contenu de la session</h3>
        <div id="popup-body">
            
        </div>
    </div>
</div>

            
        
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
            console.log("ERRUER");

        },
        error: function() {
            console.log("ERRUER");
        }
    });
});

$(document).on('click', '.eval-btn', function() {
    var evalId = $(this).data('eval-id');
    var statutId = $(this).val();
    var userId = $(this).data('user-id');
    var abiId = $(this).data('abi-id');
    var sessId = $(this).data('sess-id');

    $.ajax({
        url: '/commentaireEval',
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
            $('#popup').html(response.html);
            $('#popup').fadeIn();

            $('.popup-close').on('click', function() {
                $('#popup').fadeOut();
            });

            $(window).on('click', function(event) {
                if ($(event.target).hasClass('popup-overlay')) {
                    $('#popup').fadeOut();
                }
                if ($(event.target).hasClass('popup-submit')) {
                    var evalId = $(event.target).data('eval-id');
                    var contenu = $('.popup-comment').val();
                    console.log("Eval id : " + evalId);
                    console.log("Contenu : " + contenu);
                    
                    $.ajax({
                        url: '/updateCommentaire',
                        type: 'POST',
                        data: {
                            eval_id: evalId,
                            contenu: contenu,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log("OUIII");

                        },
                        error: function() {
                            console.log("ERRUER");
                        }
                    });




                }
            });


        },
        error: function() {
            console.log("Erreur lors de l'appel AJAX.");
        }
    });
});



    
    $('.popup-close').on('click', function() {
            $('#popup').fadeOut(); 
        });

    $(window).on('click', function(event) {
        if ($(event.target).hasClass('popup-overlay')) {
            $('#popup').fadeOut(); 
        }
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

.popup-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
}

.popup-content {
    background-color: white;
    padding: 20px;
    border-radius: 12px;
    max-width: 400px;
    width: 90%;
    text-align: center;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
}


.popup-close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    font-weight: bold;
    color: #333;
    cursor: pointer;
}


    </style>
    
@endsection
