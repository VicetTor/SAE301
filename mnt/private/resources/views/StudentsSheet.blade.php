@extends('Base')

@section('title','a définir')

@section('content')


<?php

use App\Models\Ability;
use App\Models\Attend;
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



        @if(session()->missing('user_mail'))
            <p> PAS CONNECTE </p>
        @endif
        @if(session('type_id') != 3)
            <!-- Rediriger au profil !-->
            <p> Vous n'etes pas un initiateur </p>
        @endif

        <p> Bonjour {{ session('user_firstname') }} {{ session('user_lastname') }} </p>
        <p> Vous etes niveau {{ session('level_id') }}

        <select id="selectEleve">
            @foreach($eleves as $eleve)
                <option value="{{ $eleve->USER_ID }}">
                    {{$eleve->USER_FIRSTNAME}} {{$eleve->USER_LASTNAME}}
                </option>
            @endforeach
        </select>
        <h1 id="result">aaA </h1>

        <table id=tabletable>
        <thead>
        <tr>
            <th></th>
            @foreach($skills as $skill)
                @php
                $nbAbility = $skill->count();
                @endphp

                <?php
                $nombre = Ability::select('*')
                ->where('SKILL_ID', '=', $skill->SKILL_ID)
                ->count();
                ?>

                <!-- Ici sont généré les gros skills !-->
                <th colspan="{{ $nombre }}">{{ $skill->SKILL_LABEL }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
            <tr>
            <th></th>
            @php $nbAbility = 0; @endphp
            @foreach($skillsWithAbilities as $skillId => $abilities)
                @foreach($abilities as $ability)
                    <td>
                        <!-- Ici est généré le nom de chaque abilité !-->
                    {{ $ability->ABI_LABEL }}
                    </td>
                    @php
                        $nbAbility++;
                    @endphp
                @endforeach
            @endforeach
            </tr>

            @php $i = 0; @endphp

            @foreach($sessions as $session)
            <tr>
                <!-- Ici est générée la date de chaque session !-->
                <td>
                    {{$session->SESS_DATE}}
                </td>
                
                @foreach($skillsWithAbilities as $abilities)
                    @foreach($abilities as $ability)
                        
                    @php
                        $evaluationTrouvee = null;
                        $found = false;

                        foreach($evaluationsChaqueSeance[$i] as $eval) {
                            if ($eval->ABI_ID == $ability->ABI_ID) {
                                $evaluationTrouvee = $eval;
                                $found = true;
                                break;
                            }
                        }

                        if (!$found) {
                            $eval = new Evaluation();
                            $eval->EVAL_ID = 0;  // ou une valeur par défaut si nécessaire
                        }
                    @endphp


                        <!-- Ici sont générées les cases "Absent", "En cours d'acquisition", ect...  !-->
                        <td>
                        {{$eval->EVAL_ID}}
                        @if($session->SESS_DATE > now())
                            <select class="scroll" 
                                data-user-id="{{ $user_id }}" 
                                data-abi-id="{{ $ability->ABI_ID }}" 
                                data-sess-id="{{ $session->SESS_ID }}"
                                data-eval-id="{{$eval->EVAL_ID}}"
                                >

                        @endif


                            
                            @if($session->SESS_DATE > now())
                                @if($evaluationTrouvee)
                                        <option>
                                            {{$evaluationTrouvee->STATUSTYPE_LABEL}} 
                                        </option>
                                    @else
                                    <option></option>
                                @endif
                                @foreach($statustype as $statutype)
                                    
                                    <option value="{{$statutype->STATUSTYPE_ID}}">
                                        {{$statutype->STATUSTYPE_LABEL}}
                                    </option>
                                 @endforeach
                            @elseif($evaluationTrouvee)
                                {{$evaluationTrouvee->STATUSTYPE_LABEL}}
                            @endif
                            @if($session->SESS_DATE > now())
                                </select>
                            @endif
                        </td>
                    @endforeach
                @endforeach
            </tr>


            @php
            $i++;
            @endphp
            @endforeach
            
        
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
        $('#selectEleve').change(function() {
            var userId = $(this).val();

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


        $('.scroll').change(function() {
    var evalId = $(this).data('eval-id'); 
    var selectedStatus = $(this).val();
    var user_id = $(this).data('user-id');
    var abi_id = $(this).data('abi-id');
    var sess_id = $(this).data('sess-id');
    if(evalId )
    console.log(evalId);

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
                alert(response.message);  // Afficher le message retourné par le contrôleur
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
        table {
        width: 50%;
        border-collapse: collapse;
        margin: 20px 0;
        font-family: Arial, sans-serif;
        }

        th, td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
        }

        th {
        background-color: #f2f2f2;
        }

        tr:nth-child(even) {
        background-color: #f9f9f9;
        }
        td > select{
            margin: 0px;
            padding: 0px;
        }
    </style>
    
@endsection
