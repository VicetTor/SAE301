@extends('Base')

@section('title','Tableau Bilan')

@section('content')

<?php

    use App\Models\Ability;
    use App\Models\Attendee;
    use App\Models\Evaluation;
    use App\Models\Skill;

    $user_id = session('user_id');
    $level = session('level_id_resume');
    $skills = Skill::select('*')
        ->where('LEVEL_ID','=',$level)->get();

    $sessions = Attendee::select('*', 'GRP2_USER.*')
        ->join('GRP2_USER', 'GRP2_ATTENDEE.USER_ID_attendee', '=', 'GRP2_USER.USER_ID')
            ->join('GRP2_SESSION', 'GRP2_SESSION.SESS_ID', '=', 'GRP2_ATTENDEE.SESS_ID')
                ->where('GRP2_USER.USER_ID', '=', $user_id)
                    ->get();

    $evaluationsChaqueSeance = [];
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

    $taille = 0;
    foreach($skills as $skill){
        $taille += Ability::select('*')
            ->where('SKILL_ID', '=', $skill->SKILL_ID)
                ->count();
    }

?>

<!-- Mise en page-->

    @if(session()->missing('user_mail'))
        <p class="fw-medium fs-1"> Vous êtes actuellement NON CONNECTÉ </p>
    @endif

    <p class="fw-medium fs-3"> Vous êtes connecté(e) en tant que : {{ session('user_firstname') }} {{ session('user_lastname') }} </p>
    <p class="fst-italic fs-5"> Votre progression vers le Niveau {{ session('level_id_resume') }}</p>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Compétence</th>
                <th>Aptitude</th>
                <th>Évolution</th>
            </tr> 
        </thead>  
        <tbody>
            @php 
                $i = 0; 
            @endphp
            @foreach ($sessions as $session)
                <!-- insére les dates -->
                <td rowspan="{{ $taille }}" class="session-date">
                    {{ $session->SESS_DATE }}
                </td>
                @foreach ($skills as $skill)
                    @php
                        $nombre = Ability::select('*')
                            ->where('SKILL_ID', '=', $skill->SKILL_ID)
                                ->count();
                    @endphp
                    <!-- insére les compétences -->
                    <td rowspan="{{$nombre}}" class="skill">
                        {{ $skill->SKILL_LABEL }}
                    </td>
                    @php
                        $aptitude = Ability::select('*')
                            ->where('SKILL_ID', '=', $skill->SKILL_ID)->get();
                        $compteur = 0;
                    @endphp
                    @foreach($aptitude as $apt)
                        @php
                            $evaluationTrouvee = null;
                            foreach($evaluationsChaqueSeance[$i] as $eval) {
                                if($eval->ABI_ID == $apt->ABI_ID){ 
                                    $evaluationTrouvee = $eval;
                                    break;
                                }
                            }
                        @endphp 
                        @if($compteur != 0) 
                            <tr> 
                        @endif
                        <!-- insére les aptitudes -->
                        <td class = "ability">
                            {{$apt->ABI_LABEL}}
                        </td>
                        <!-- insére les évaluations -->
                        <td class="eval"> 
                            @if($evaluationTrouvee) 
                                {{$evaluationTrouvee->STATUSTYPE_LABEL}}
                            @else
                                Non évaluée
                            @endif
                        </td>
                        </tr>
                        @if($compteur != 0) 
                            </tr> 
                        @endif
                        @php 
                            $compteur++; 
                        @endphp
                    @endforeach
                    </td>
                @endforeach
                </td>
                @php
                    $i++;   
                @endphp 
            @endforeach
        </tbody>
    </table>




<!-- script JS -->

<script>
    const table = document.querySelector("table");
    const cells = table.getElementsByClassName("eval");
    for (let i = 0; i < cells.length; i++) {
        const cell = cells[i];
        const text = cell.textContent.trim();
        if (text == "Acquise") {
            cell.style.color = "white";
            cell.style.backgroundColor = "green";
        } 
        else if (text == "En Cours d'Acquisition") {
            cell.style.color = "white";
            cell.style.backgroundColor = "orange";
        }
        else if (text == "Absent") {
            cell.style.color = "white";
            cell.style.backgroundColor = "red";
        }
        else if (text == "Non évaluée") {
            cell.style.color = "red";
            cell.style.backgroundColor = "#e6e4e4e5";
        }
    }
</script>


@endsection
