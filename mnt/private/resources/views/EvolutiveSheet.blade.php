@extends('Base')

@section('title','Tableau évolutif')

@section('content')

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
    foreach($sessions as $session){
        $evaluations = Evaluation::select('*')
            ->join('GRP2_STATUSTYPE', 'GRP2_STATUSTYPE.STATUSTYPE_ID', '=', 'GRP2_EVALUATION.STATUSTYPE_ID')
                ->join('GRP2_SESSION', 'GRP2_SESSION.SESS_ID', '=', 'GRP2_EVALUATION.SESS_ID')
                    ->where('GRP2_EVALUATION.SESS_ID', '=', $session->SESS_ID)
                        ->where('GRP2_EVALUATION.USER_ID', '=', $user_id)
                            ->get();
        $evaluationsChaqueSeance[$i] = $evaluations;
        $i++;
    }
?>

<!-- Mise en page-->

<table>
    
    @if(session()->missing('user_mail'))
        <p> Vous êtes actuellement NON CONNECTÉ </p>
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
document.addEventListener('DOMContentLoaded', function() {
    const cells = document.querySelectorAll("td.eval");
    
    cells.forEach(cell => {
        const text = cell.textContent.trim();
        switch(text) {
            case "Acquise":
                cell.style.color = "white";
                cell.style.backgroundColor = "green";
                break;
            case "En Cours d'Acquisition":
                cell.style.color = "white";
                cell.style.backgroundColor = "orange";
                break;
            case "Absent":
                cell.style.color = "white";
                cell.style.backgroundColor = "red";
                break;
            case "Non évaluée":
                cell.style.color = "red";
                cell.style.backgroundColor = "#e6e4e4";
                break;
        }
    });
});

</script>


@endsection
