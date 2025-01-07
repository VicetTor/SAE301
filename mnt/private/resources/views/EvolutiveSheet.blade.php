@extends('Base')

@section('title','a définir')

@section('content')

    <?php

use App\Models\Ability;
use App\Models\Attend;
use App\Models\Evaluation;
use App\Models\Skill;

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


    $sessions = Attend::select('ATTEND.*', 'GRP2_USER.*')
    ->join('GRP2_ATTENDEE', 'GRP2_ATTENDEE.ATTE_ID', '=', 'ATTEND.ATTE_ID')
    ->join('GRP2_USER', 'GRP2_ATTENDEE.USER_ID', '=', 'GRP2_USER.USER_ID')
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



    ?>



        @if(session()->missing('user_mail'))
            <p> PAS CONNECTE </p>
        @endif

        <p> Bonjour {{ session('user_firstname') }} {{ session('user_lastname') }} </p>
        <p> Vous etes niveau {{ session('level_id') }}


        <table>
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
                    {{$session->SESSION_DATE}}
                </td>
                
                @foreach($skillsWithAbilities as $abilities)
                    @foreach($abilities as $ability)
                        @php
                            $evaluationTrouvee = null;

                            foreach($evaluationsChaqueSeance[$i] as $eval) {
                                if ($eval->ABI_ID == $ability->ABI_ID) {
                                    $evaluationTrouvee = $eval;
                                    break;
                                }
                            }
                        @endphp

                        <!-- Ici sont générées les cases "Absent", "En cours d'acquisition", ect...  !-->
                        <td>
                            @if($evaluationTrouvee)
                                {{$evaluationTrouvee->STATUSTYPE_LABEL}}
                            @else
                            
                            @endif
                        </td>
                    @endforeach
                @endforeach
            </tr>




            @php
            $i++;
            @endphp
            @endforeach
            
        
        
    </tbody>
    </table>

    <!-- Vous pouvez supprimer ce css bien sur cetait juste pour etre lisible en attendant !-->
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
    </style>
    @endsection
