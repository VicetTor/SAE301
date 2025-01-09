@extends('Base') <!-- Extends the base layout template -->

@section('title','Tableau évolutif')

@section('content') <!-- Content section that will be inserted into the base layout -->

<?php

    use App\Models\Ability;
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
        <p> PAS CONNECTE </p> <!-- "Not connected" -->
    @endif

    <!-- Greet the user with their first and last name from the session -->
    <p> Bonjour {{ session('user_firstname') }} {{ session('user_lastname') }} </p> <!-- Greeting the user -->
    
    <!-- Display the user's level -->
    <p> Vous etes niveau {{ session('level_id') }} </p> <!-- Display user's level -->

    @if(session()->missing('user_mail'))
        <p> Vous êtes actuellement NON CONNECTÉ </p>
    @endif

    <p> Bonjour {{ session('user_firstname') }} {{ session('user_lastname') }} </p>
    <p> Votre progression vers le Niveau {{ session('level_id_resume') }}</p>

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
                $j = 0; 
            @endphp
            
            @foreach ($sessions as $session)
            
            <?php
            
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
            foreach($skills as $skill){

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
                <!-- insére les dates -->
                <td rowspan="{{ $taille }}" class="session-date">
                    {{ $session->SESS_DATE }}
                </td>
                @php $debug = 0; @endphp
                @foreach ($skills as $skill)
                    
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

                    <!-- insére les compétences -->
                    <td rowspan="{{$nombre}}" class="skill">
                        {{ $skill->SKILL_LABEL }} {{$nbSkills}}
                    </td>

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
                    @php $debug++; @endphp

                @endforeach
                </td>
                @php
                    $i++;  
                    $j++; 
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
