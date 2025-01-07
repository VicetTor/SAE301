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
    $nbSkill = $skills->count();

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
            ->join('GRP2_STATUSTYPE', 'GRP2_STATUSTYPE.STATUSTYPE_ID', '=', 'GRP2_EVALUATION.SESS_ID')
            ->join('GRP2_SESSION', 'GRP2_SESSION.SESS_ID', '=', 'GRP2_EVALUATION.SESS_ID')
            ->where('GRP2_EVALUATION.SESS_ID', '=', $session->SESS_ID)
            ->get();
        $evaluationsChaqueSeance[$i] = $evaluations;
        $i++;
    }

    echo $evaluationsChaqueSeance[0];


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
                <th colspan="{{ $nbAbility }}">{{ $skill->SKILL_LABEL }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
            <tr>
            <th></th>
            @foreach($skillsWithAbilities as $skillId => $abilities)
                @foreach($abilities as $ability)
                    <td>
                    {{ $ability->ABI_LABEL }}
                    </td>
                @endforeach
            @endforeach
            </tr>

            @php
            $i = 0;
            @endphp
            @foreach($sessions as $session)
            <tr>
                <td>
                 {{$session->SESSION_DATE}}
                </td>
                

                <!-- Affiche chaque evaluation de chaque competence pour la session 
                     Il faut que ca fasse une boucle i a chaque fois de la meme longueur que le nb de case en longueur
                     et ensuite si il faut que ca place le tout au bon endroit
                !-->
                
            </tr>
            @endforeach
            
        
        
    </tbody>
    </table>

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
