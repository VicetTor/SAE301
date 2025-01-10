@extends('Base')

@section('title','Tableau Bilan')

@section('content')

<?php

    use App\Models\Ability;
    use App\Models\Attendee;
    use App\Models\Evaluation;
    use App\Models\Skill;
    use App\Models\Level;

    $user_id = session('user_id');
    $levelPreparer = session('level_id_resume');
    

    /*query that retrieves levels already obtained and those in preparation*/
    $niveaux = Level::select('*')
    ->where('LEVEL_ID','<=',$levelPreparer)
    ->get();

    /*request to retrieve the preparation level*/
    $niveaux2 = Level::select('*')
    ->where('LEVEL_ID','=',$levelPreparer)
    ->get();

    /*query that retrieves levels already obtained*/
    $niveaux3 = Level::select('*')
    ->where('LEVEL_ID','<',$levelPreparer)
    ->get();

    $sessions = Attendee::select('*', 'grp2_user.*')
    ->join('grp2_user', 'grp2_attendee.USER_ID_attendee', '=', 'grp2_user.USER_ID')
    ->join('grp2_session', 'grp2_session.SESS_ID', '=', 'grp2_attendee.SESS_ID')
    ->where('grp2_user.USER_ID', '=', $user_id)
    ->get();

    $evaluationsChaqueSeance = [];
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


    

?>

    
    <!-- test if you are not connected and displays a message accordingly -->
    @if(session()->missing('user_mail'))
        <p class="fw-medium fs-3"> Vous êtes actuellement NON CONNECTÉ </p>
    @endif
    <!-- displays the first and last name of the account you're logged in to -->
    <p class="fw-medium fs-3"> Vous êtes connecté(e) en tant que : {{ session('user_firstname') }} {{ session('user_lastname') }} </p>
    <!-- displays levels already reached -->
    <p class="fst-italic fs-5"> vous avez le(s) niveau(x) : 
        @foreach($niveaux3 as $niveau)
            {{ $niveau->LEVEL_LABEL }}
        @endforeach
    </p>
    <!-- displays the level being prepared -->
    <p class="fst-italic fs-5"> Votre progression vers :
        @foreach($niveaux2 as $niveau)
            {{ $niveau->LEVEL_LABEL }}
        @endforeach
    </p>

    <table>
        <!-- displays the top of the table -->
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
            <!-- foreach for all levels -->
            @foreach ($niveaux as $niveau)
                @if ($niveau->LEVEL_ID == 0)
                    @continue
                @endif
                <!-- request that retrieves skills -->
                @php
                    $skills = Skill::select('*')
                    ->where('LEVEL_ID','!=','0')
                    ->where('LEVEL_ID','=',$niveau->LEVEL_ID)
                    ->get();
                @endphp
                <!-- foreach that runs through all skills -->
                @php
                    $taille = 0;
                    foreach($skills as $skill) {
                        $taille += \App\Models\Ability::where('SKILL_ID', '=', $skill->SKILL_ID)->count();
                    }
                @endphp
                <!-- line that inserts the dates -->
                <td rowspan="{{ $taille }}" class="session-date">
                    {{ $niveau->LEVEL_LABEL }}
                </td>
                <!-- foreach that runs through all skills -->
                @foreach ($skills as $skill)
                    <!-- query that counts the number of ability -->
                    @php
                        $nombre = Ability::select('*')
                            ->where('SKILL_ID', '=', $skill->SKILL_ID)
                                ->count();
                    @endphp
                    <!-- inserts skills -->
                    <td rowspan="{{$nombre}}" class="skill">
                        {{ $skill->SKILL_LABEL }}
                    </td>
                    <!-- requête qui récupère les abilitys -->
                    @php
                        $aptitude = Ability::select('*')
                            ->where('SKILL_ID', '=', $skill->SKILL_ID)->get();
                        $compteur = 0;
                    @endphp
                    <!-- request that retrieves abilitys -->
                    @foreach($aptitude as $apt)
                        @if($compteur != 0) 
                            <tr> 
                        @endif
                        <!-- line that inserts the ability -->
                        <td class = "ability">
                            {{$apt->ABI_LABEL}}
                        </td>
                        <!-- line that inserts evaluations -->
                        <td class="eval"> 
                                @php
                                $nbEvals = Evaluation::select('*')
                                ->where('USER_ID', '=', $user_id)
                                ->where('ABI_ID','=',$apt->ABI_ID)
                                ->count();
                                
                                $nbEvalsValide = Evaluation::select('*')
                                ->where('USER_ID', '=', $user_id)
                                ->where('ABI_ID','=',$apt->ABI_ID)
                                ->where('STATUSTYPE_ID', '=', 3)
                                ->count();
                                @endphp

                                @if($nbEvalsValide >= 3)
                                    Validé
                                @elseif($nbEvals > 0)
                                    En cours
                                @else
                                    Non évalué
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
