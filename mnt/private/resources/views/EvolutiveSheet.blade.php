@extends('Base')

@section('title','Progression')

@section('content')

<?php
    use App\Models\Ability;
    use App\Models\Attend;
    use App\Models\Evaluation;
    use App\Models\Skill;

    $user_id = session('user_id');
    $level = session('level_id_resume');
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
?>

<div>
    @if(session()->missing('user_mail'))
        <p> Vous êtes actuellement NON CONNECTÉ </p>
    @endif

    <p> Bonjour {{ session('user_firstname') }} {{ session('user_lastname') }} </p>
    <p> Votre progression vers le Niveau {{ session('level_id') }}</p>

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
                @php 
                    $cpt = 0;
                @endphp
                
                @foreach ($skills as $skill)
                    @php
                        $nombre = Ability::select('*')
                            ->where('SKILL_ID', '=', $skill->SKILL_ID)
                            ->count();
                    @endphp
                    @foreach($skillsWithAbilities as $skillId => $abilities)
                        @foreach($abilities as $ability)
                            @php
                                $evaluationTrouvee = null;
                                foreach($evaluationsChaqueSeance[$i] as $eval) {
                                    $evaluationTrouvee = $eval;
                                    break;
                                }
                            @endphp
                            <tr>
                                @if($evaluationTrouvee == $eval) 
                                    @if($cpt == 0)
                                        <!-- Date de la session affichée -->
                                        <td rowspan="{{ $nombre * 7 + 1 }}" class="session-date">{{ $session->SESSION_DATE }}</td>
                                    @endif
                                    <!-- Compétence affichée -->
                                    <td>{{ $skill->SKILL_LABEL }}</td> 
                                    <!-- Aptitude affichée -->
                                    <td>{{ $ability->ABI_LABEL }}</td>  
                                    <!-- Évaluation de l'évolution -->
                                    <td>{{ $evaluationTrouvee->STATUSTYPE_LABEL }}</td>
                                @endif
                            </tr>
                            @php
                                $cpt = 1; 
                            @endphp
                        @endforeach
                    @endforeach
                @endforeach
                @php
                    $i++;   
                @endphp       
            @endforeach    
        </tbody>
    </table>
</div>



<script>
    const table = document.querySelector("table");
    const cells = table.getElementsByTagName("td");
    for (let i = 0; i < cells.length; i++) {
        const cell = cells[i];
        const text = cell.textContent;
        if (text === "Acquise") {
            cell.style.backgroundColor = "green";
        } 
        else if (text === "En cours d'acquisition") {
            cell.style.backgroundColor = "orange";
        }
        else if (text === "Absent") {
            cell.style.backgroundColor = "red";
        }
    }
</script>

@endsection
