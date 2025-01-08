@extends('Base')
@section('title','Page des séances')
@section('content')

    {{session(['verify' => '0'])}}

    @if(session('user_mail'))
        <p>bonjour {{ session('user_mail')  }}</p>
    @else
        <p>Aucun utilisateur connecté.</p>
    @endif


    <div class="paragraphe-bienvenue">
        <p>
            <strong>Bienvenue dans le club : {{$club->club_name}} </strong>
            <br>
            Sed mattis, erat sit amet gravida malesuada, elit augue egestas diam, tempus scelerisque nunc nisl vitae libero. Sed consequat feugiat massa. Nunc porta, eros in eleifend varius, erat leo rutrum dui, non convallis lectus orci ut nibh. Sed lorem massa, nonummy quis, egestas id, condimentum at, nisl. Maecenas at nibh. Aliquam et augue at nunc pellentesque ullamcorper. Duis nisl nibh, laoreet suscipit, convallis ut, rutrum id, enim. Phasellus odio. Nulla nulla elit, molestie non, scelerisque at, vestibulum eu, nulla. Ut odio nisl, facilisis id, mollis et, scelerisque nec, enim. Aenean sem leo, pellentesque sit amet, scelerisque sit amet, vehicula pellentesque, sapien.
        </p>
    </div>

    <div class="seances">

        <h2> Mes séances : </h2>
        @foreach($sessions as $session)
            @if($session->SESS_ID != session('verify'))
                <p>-------------------------------------------------------------</p>
                {{session(['verify' => $session->SESS_ID])}}
                <div class="seance">
                    <ul>
                        <li>Session Date: {{$session->SESS_DATE}}</li>
                        <li>Niveau: {{$session->LEVEL_ID}} </li>
                        <li>Skill C: {{$session->SKILL_LABEL}} </li>
                    </ul>
                    <div class="abilities">

                        <h4>Abilities: </h4>
                        <ul>
                            @foreach($abilities as $ability )
                            <li>
                                    {{$ability->ABI_LABEL}}
                            </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        @endforeach

    </div>

    <div class="progression">
        <input type="button" name="" value="Consulter ma progression">
    </div>

@endsection
