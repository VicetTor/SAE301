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
    


    $niveaux = Level::select('*')
    ->where('LEVEL_ID','<=',$levelPreparer)
    ->get();
    
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


    

?>



<p> 
    @foreach($niveaux as $niveau)
        {{ $niveau->LEVEL_LABEL }} <!-- Remplacez 'name' par le champ que vous souhaitez afficher -->
    @endforeach
</p>




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
            @foreach ($niveaux as $niveau)
            @if ($niveau->LEVEL_ID == 0)
                @continue
            @endif

            @php
                $skills = Skill::select('*')
                ->where('LEVEL_ID','!=','0')
                ->where('LEVEL_ID','=',$niveau->LEVEL_ID)
                ->get();
            @endphp

            @php
                $taille = 0;
                foreach($skills as $skill) {
                    $taille += \App\Models\Ability::where('SKILL_ID', '=', $skill->SKILL_ID)->count();
                }
            @endphp



                <!-- insére les dates -->
                <td rowspan="{{ $taille }}" class="session-date">
                    {{ $niveau->LEVEL_LABEL }}
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
