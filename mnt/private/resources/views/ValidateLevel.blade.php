@extends('Base')

@section('title','a définir')

@section('content')
    <?php

use App\Models\Ability;
use App\Models\Evaluation;
use App\Models\Skill;
use App\Models\User;
    ?>
    <h1>Valider les compétences</h1>

    <?php
        $user = User::select('*')
        ->where('LEVEL_ID_RESUME', '=', '1')
        ->orWhere('LEVEL_ID_RESUME', '=', '2')
        ->orWhere('LEVEL_ID_RESUME', '=', '3')
        ->get();

        foreach($user as $user){
            $isValide = true;

            $competencesDeUser = Skill::select('*')
            ->where('LEVEL_ID', '=', $user->LEVEL_ID_RESUME)
            ->get();
            
            foreach($competencesDeUser as $competence){
                $aptitudesDeUser = Ability::select('*')
                ->where('SKILL_ID', '=', $competence->SKILL_ID)
                ->get();

                foreach($aptitudesDeUser as $aptitude){ 
                    $nbAcquisDeApt = Evaluation::select('*')
                    ->where('ABI_ID', '=', $aptitude->ABI_ID)
                    ->where('USER_ID', '=', $user->USER_ID)
                    ->where('STATUSTYPE_ID', '=', '3')
                    ->count();

                    if($nbAcquisDeApt >= 3){
                        
                    } else{
                        $isValide = false;
                    }
                }
            }
            if($isValide){
                echo'<h3 class="text-center darkblue-text">'.$user->USER_FIRSTNAME.'</h3>';
                echo'<h2> Prépare le niveau '.$user->LEVEL_ID_RESUME;
                echo'<br/><button class="bouton-valider" data-user-id="'.$user->USER_ID.'" data-level-resume="'.$user->LEVEL_ID_RESUME.'"> valider la competence </button>';
            }
        }
    ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>    
    $(document).on('click', '.bouton-valider', function(event) {
        var userId = $(this).data('user-id');
        var idResume = $(this).data('level-resume');

        console.log("User id : " + userId);
        console.log("Level resume id : " + idResume);

        $.ajax({
            url: '/validerNiveau',
            type: 'POST',
            data: {
                user_id: userId,
                id_resume: idResume,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log("OUIII");
                location.reload();
            },
            error: function() {
                console.log("ERRUER");
            }
        });
    });
</script>

<style>
.userName{
    background-color: red;
}


</style>

@endsection
