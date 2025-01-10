@extends('Base') <!-- Extends the base layout template -->

@section('title','Tableau évolutif')

@section('content') <!-- Content section that will be inserted into the base layout -->

<?php

use App\Models\Ability;
use App\Models\Attend;
use App\Models\Attendee;
use App\Models\Evaluation;
use App\Models\Skill;

    use Illuminate\Support\Facades\DB;


    $user_id = session('user_id');
    $level = session('level_id_resume');
   
    $sessions = Attendee::select('*', 'GRP2_USER.*')
    ->join('GRP2_USER', 'GRP2_ATTENDEE.USER_ID_attendee', '=', 'GRP2_USER.USER_ID')
    ->join('GRP2_SESSION', 'GRP2_SESSION.SESS_ID', '=', 'GRP2_ATTENDEE.SESS_ID')
    ->where('GRP2_USER.USER_ID', '=', $user_id)
    ->get();



    $evaluationsChaqueSeance = [];
    $i = 0;

    // For each session, fetch evaluations
    foreach ($sessions as $session) {
        $evaluations = Evaluation::select('*')
            ->join('GRP2_STATUSTYPE', 'GRP2_STATUSTYPE.STATUSTYPE_ID', '=', 'GRP2_EVALUATION.STATUSTYPE_ID')
            ->join('GRP2_SESSION', 'GRP2_SESSION.SESS_ID', '=', 'GRP2_EVALUATION.SESS_ID')
            ->where('GRP2_EVALUATION.SESS_ID', '=', $session->SESS_ID)
            ->where('GRP2_EVALUATION.USER_ID', '=', $user_id)
            ->get();
        
        // Store the evaluations for each session
        $evaluationsChaqueSeance[$i] = $evaluations;
        $i++;
    }
?>

    <!-- If the user is not logged in (session 'user_mail' is missing), show a "not connected" message -->
    @if(session()->missing('user_mail'))
        <p> Vous êtes actuellement NON CONNECTÉ </p>
    @endif

    <!-- Greet the user with their first and last name from the session -->
    <p class="fw-medium fs-3"> Vous êtes connecté(e) en tant que : {{ session('user_firstname') }} {{ session('user_lastname') }} </p>

    <!-- Display the user's level -->
    <p class="fst-italic fs-5"> Vous etes niveau {{ session('level_id') }} </p> <!-- Display user's level -->

    <!-- Display the user's target level -->
    <p class="fst-italic fs-5"> Votre progression vers le Niveau {{ session('level_id_resume') }}</p> <!-- Display the user's target level -->

    <table>
        <!-- Displays the table header -->
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
            <!-- foreach to browse all sessions --->
            @foreach ($sessions as $session)
                <?php
                    /* request that allows you to have all the skills worked on during a session */
                    $skills = DB::select(DB::raw('
                    select distinct GRP2_SKILL.SKILL_ID, GRP2_SKILL.SKILL_LABEL from GRP2_SKILL
                    inner join GRP2_ABILITY using (SKILL_ID)
                    inner join GRP2_EVALUATION using (ABI_ID)
                    where GRP2_EVALUATION.SESS_ID ='.$session->SESS_ID.'
                    and GRP2_SKILL.LEVEL_ID ='.$level.'
                    and GRP2_EVALUATION.USER_ID ='.$user_id
                    ));
                    $nbSkills = count($skills);
                    $taille = 0;
                    /* foreach to browse all skills */
                    foreach($skills as $skill){
                        /* request that allows you to have all the skills you've worked on during a session */
                        $result = DB::select(DB::raw('
                        select * from GRP2_ABILITY
                        inner join GRP2_EVALUATION using (ABI_ID)
                        where GRP2_ABILITY.SKILL_ID ='.$skill->SKILL_ID.'
                        and GRP2_EVALUATION.SESS_ID ='.$session->SESS_ID.'
                        and GRP2_EVALUATION.USER_ID ='.$user_id
                        ));

                        $taille+=count($result);
                    }
                ?>
                <!-- line that inserts the dates -->
                <td rowspan="{{ $taille }}" class="session-date">
                    {{ $session->SESS_DATE }}
                </td>
                <!-- foreach to browse all skills --->
                @foreach ($skills as $skill)
                    <!-- request that allows you to have all the skills you've worked on during a session --->
                    <?php
                            $result = DB::select(DB::raw('
                            select * from GRP2_ABILITY
                            inner join GRP2_EVALUATION using (ABI_ID)
                            where GRP2_EVALUATION.SESS_ID ='.$session->SESS_ID.'
                            and GRP2_EVALUATION.USER_ID ='.$user_id.'
                            and GRP2_ABILITY.SKILL_ID ='.$skill->SKILL_ID
                            ));
                            $nombre = count($result);
                    ?>

                    <!-- line that inserts the skills -->
                    <td rowspan="{{$nombre}}" class="skill">
                        {{ $skill->SKILL_LABEL }} {{$nbSkills}}
                    </td>
                        <!-- query that lets you see all the skills worked on during a session --->
                    <?php
                        $aptitude = DB::select(DB::raw('
                            select * from GRP2_ABILITY
                            inner join GRP2_EVALUATION using (ABI_ID)
                            where SKILL_ID = '.$skill->SKILL_ID.'
                            and GRP2_EVALUATION.SESS_ID ='.$session->SESS_ID.'
                            and GRP2_EVALUATION.USER_ID ='.$user_id

                        ));
                        $compteur = 0;
                    ?>

                    <!-- foreach to browse all abilitys of the session --->
                    @foreach($aptitude as $apt)
                        <!-- allows you to test whether there are evaluations that are rated --->
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
                        <!-- line for inserting ability -->
                        <td class = "ability">
                            {{$apt->ABI_LABEL}}
                        </td>
                        <!-- line for inserting evaluations -->
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