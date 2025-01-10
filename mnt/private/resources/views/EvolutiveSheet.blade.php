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
   
    $sessions = Attendee::select('*', 'grp2_user.*')
    ->join('grp2_user', 'grp2_attendee.USER_ID_ATTENDEE', '=', 'grp2_user.USER_ID')
    ->join('grp2_session', 'grp2_session.SESS_ID', '=', 'grp2_attendee.SESS_ID')
    ->where('grp2_user.USER_ID', '=', $user_id)
    ->get();



    $evaluationsChaqueSeance = [];
    $i = 0;

    // For each session, fetch evaluations
    foreach ($sessions as $session) {
        $evaluations = Evaluation::select('*')
            ->join('grp2_statustype', 'grp2_statustype.STATUSTYPE_ID', '=', 'grp2_evaluation.STATUSTYPE_ID')
            ->join('grp2_session', 'grp2_session.SESS_ID', '=', 'grp2_evaluation.SESS_ID')
            ->where('grp2_evaluation.SESS_ID', '=', $session->SESS_ID)
            ->where('grp2_evaluation.USER_ID', '=', $user_id)
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
            
            $skills = DB::select(DB::raw('
            select distinct grp2_skill.SKILL_ID, grp2_skill.SKILL_LABEL from grp2_skill
            inner join grp2_ability using (SKILL_ID)
            inner join grp2_evaluation using (ABI_ID)
            where grp2_evaluation.SESS_ID ='.$session->SESS_ID.'
            and grp2_skill.LEVEL_ID ='.$level.'
            and grp2_evaluation.USER_ID ='.$user_id
            ));
            


            $nbSkills = count($skills);
            $taille = 0;
            foreach($skills as $skill){

                $result = DB::select(DB::raw('
                select * from grp2_ability
                inner join grp2_evaluation using (ABI_ID)
                where grp2_ability.SKILL_ID ='.$skill->SKILL_ID.'
                and grp2_evaluation.SESS_ID ='.$session->SESS_ID.'
                and grp2_evaluation.USER_ID ='.$user_id
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
                    
                <?php
                        $result = DB::select(DB::raw('
                        select * from grp2_ability
                        inner join grp2_evaluation using (ABI_ID)
                        where grp2_evaluation.SESS_ID ='.$session->SESS_ID.'
                        and grp2_evaluation.USER_ID ='.$user_id.'
                        and grp2_ability.SKILL_ID ='.$skill->SKILL_ID
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
                    select * from grp2_ability
                    inner join grp2_evaluation using (ABI_ID)
                    where SKILL_ID = '.$skill->SKILL_ID.'
                    and grp2_evaluation.SESS_ID ='.$session->SESS_ID.'
                    and grp2_evaluation.USER_ID ='.$user_id

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