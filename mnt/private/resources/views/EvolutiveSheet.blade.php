@extends('Base') <!-- Extends the base layout template -->

@section('title','a définir') <!-- The page title is currently undefined -->

@section('content') <!-- Content section that will be inserted into the base layout -->

    <?php
    // Fetch user information from the session
    use App\Models\Ability;
    use App\Models\Attend;
    use App\Models\Evaluation;
    use App\Models\Skill;

    // Get the current user ID and level from the session
    $user_id = session('user_id');
    $level = session('level_id');
    
    // Fetch the skills based on the user's level
    $skills = Skill::select('*')
        ->where('LEVEL_ID', '=', $level)
        ->get();

    // Initialize an array to store skills with their associated abilities
    $skillsWithAbilities = [];
    $i = 0;
    
    // For each skill, fetch its associated abilities
    foreach ($skills as $skill) {
        $abilities = Ability::select('*')
            ->where('SKILL_ID', '=', $skill->SKILL_ID)
            ->get();
    
        // Store the abilities for each skill in the skillsWithAbilities array
        $skillsWithAbilities[$i] = $abilities;
        $i++;
    }

    // Fetch the sessions the user is attending
    $sessions = Attend::select('ATTEND.*', 'GRP2_USER.*')
        ->join('GRP2_ATTENDEE', 'GRP2_ATTENDEE.ATTE_ID', '=', 'ATTEND.ATTE_ID')
        ->join('GRP2_USER', 'GRP2_ATTENDEE.USER_ID', '=', 'GRP2_USER.USER_ID')
        ->where('GRP2_USER.USER_ID', '=', $user_id)
        ->get();

    // Initialize an array to store evaluations for each session
    $evaluationsChaqueSeance = [];
    $i = 0;

    // For each session, fetch evaluations
    foreach ($sessions as $session) {
        $evaluations = Evaluation::select('*')
            ->join('GRP2_STATUSTYPE', 'GRP2_STATUSTYPE.STATUSTYPE_ID', '=', 'GRP2_EVALUATION.STATUSTYPE_ID')
            ->join('GRP2_SESSION', 'GRP2_SESSION.SESS_ID', '=', 'GRP2_EVALUATION.SESS_ID')
            ->where('GRP2_EVALUATION.SESS_ID', '=', $session->SESS_ID)
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

    <!-- Table to display the skills, abilities, and session evaluations -->
    <table>
    <thead>
        <tr>
            <th></th>
            @foreach($skills as $skill) <!-- Loop through each skill -->
                @php
                    $nbAbility = $skill->count(); // Get the number of abilities for this skill
                @endphp

                <!-- Fetch the number of abilities for this skill -->
                <?php
                    $nombre = Ability::select('*')
                    ->where('SKILL_ID', '=', $skill->SKILL_ID)
                    ->count();
                ?>

                <!-- Display the skill label with a column span based on the number of abilities -->
                <th colspan="{{ $nombre }}">{{ $skill->SKILL_LABEL }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        <tr>
            <th></th>
            @php $nbAbility = 0; @endphp
            @foreach($skillsWithAbilities as $skillId => $abilities) <!-- Loop through each skill and its abilities -->
                @foreach($abilities as $ability)
                    <td>
                        <!-- Display the ability name -->
                        {{ $ability->ABI_LABEL }}
                    </td>
                    @php
                        $nbAbility++;
                    @endphp
                @endforeach
            @endforeach
        </tr>

        @php $i = 0; @endphp
        @foreach($sessions as $session) <!-- Loop through each session -->
        <tr>
            <!-- Display the session date -->
            <td>
                {{$session->SESSION_DATE}}
            </td>
            
            @foreach($skillsWithAbilities as $abilities) <!-- Loop through each skill's abilities -->
                @foreach($abilities as $ability)
                    @php
                        $evaluationTrouvee = null;

                        // Check if there is a corresponding evaluation for the current ability in the current session
                        foreach($evaluationsChaqueSeance[$i] as $eval) {
                            if ($eval->ABI_ID == $ability->ABI_ID) {
                                $evaluationTrouvee = $eval;
                                break;
                            }
                        }
                    @endphp

                    <!-- Display the evaluation status, if available -->
                    <td>
                        @if($evaluationTrouvee)
                            {{$evaluationTrouvee->STATUSTYPE_LABEL}} <!-- Display the evaluation status -->
                        @else
                            <!-- If no evaluation found, leave the cell empty -->
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

    <!-- Optional CSS for table styling (temporary for readability) -->
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
    
@endsection <!-- End of the content section -->
