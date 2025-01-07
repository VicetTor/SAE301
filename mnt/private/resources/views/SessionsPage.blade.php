@extends('Base')

@section('title','Page des séances')

@section('content')
    @if(session('user_mail'))
        <p>bonjour {{ session('user_mail')  }} {{ session('user_id') }}</p>
    @else
        <p>Aucun utilisateur connecté.</p>
    @endif

    <div class="paragraphe-bienvenue">
        <p>
            <strong>Bienvenue dans le club : {{$club->club_name}} </strong>
            Sed mattis, erat sit amet gravida malesuada, elit augue egestas diam, tempus scelerisque nunc nisl vitae libero. Sed consequat feugiat massa. Nunc porta, eros in eleifend varius, erat leo rutrum dui, non convallis lectus orci ut nibh. Sed lorem massa, nonummy quis, egestas id, condimentum at, nisl. Maecenas at nibh. Aliquam et augue at nunc pellentesque ullamcorper. Duis nisl nibh, laoreet suscipit, convallis ut, rutrum id, enim. Phasellus odio. Nulla nulla elit, molestie non, scelerisque at, vestibulum eu, nulla. Ut odio nisl, facilisis id, mollis et, scelerisque nec, enim. Aenean sem leo, pellentesque sit amet, scelerisque sit amet, vehicula pellentesque, sapien.
        </p>
    </div>

    <div class="seances">

        <h2> Mes séances : </h2>
        @for($i = 0; $i < $session[0]->nb; $i++)
            <div class="seance">
                <ul>
                    <li>Session Date: {{$seance[0]->SESSION_DATE}}</li>
                    <li>Niveau: {{$seance[0]->LEVEL_ID}}</li>
                    <li>Skill C{{$seance[0]->SKILL_ID}}: {{$seance[0]->SKILL_LABEL}}</li>
                </ul>
                <div class="abilities">
                    <h4>Abilities:</h4>
                    <ul>
                        @foreach($abilities as $ability)
                            <li>A{{$ability->ABI_ID}}: {{$ability->ABI_LABEL}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endfor

    </div>

    <div class="progression">
        <input type="button" name="" value="Consulter ma progression">
    </div>

@endsection
