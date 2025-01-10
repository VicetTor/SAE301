@extends('Base')
@section('title','Page des séances')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
@section('content')

    <!-- Start a session with a verification flag set to 0 -->
    {{session(['verify' => '0'])}}
    <div>
        <h3 class="m-2 text-center"> <strong> Mes Séances : </strong> </h3>
        <br>

        <!-- Carousel displaying sessions -->
        <div id="sessionsCarousel" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <!-- Carousel Indicators (navigation dots at the bottom) -->
            <div class="carousel-indicators">
                @if(isset($initiatorSessions) && $initiatorSessions->isNotEmpty())
                    @foreach($initiatorSessions->chunk(4) as $index => $chunk)
                        <!-- Logique alternative si $sessions n'est pas défini -->
                        <button type="button" data-bs-target="#sessionsCarousel" data-bs-slide-to="{{$index}}" class="@if($index == 0) active @endif" aria-current="true" aria-label="Slide {{$index + 1}}"></button>
                    @endforeach
                @elseif(isset($sessions))
                    @foreach($sessions->chunk(4) as $index => $chunk)
                        <!-- Create an indicator for each chunk of sessions -->
                        <button type="button" data-bs-target="#sessionsCarousel" data-bs-slide-to="{{$index}}" class="@if($index == 0) active @endif" aria-current="true" aria-label="Slide {{$index + 1}}"></button>
                    @endforeach
                @endif
                    
            </div>

            <!-- Carousel content -->
            <div class="carousel-inner">
                @if(isset($initiatorSessions) && $initiatorSessions->isNotEmpty())
                    @foreach($initiatorSessions->chunk(4) as $index => $chunk)
                        <div class="carousel-item @if($index == 0) active @endif">
                            <div class="d-flex justify-content-center">
                                @foreach($chunk as $session)
                                
                                @if($session->USER_ID == Session('user_id'))
                                
                                    <!-- Check if the session ID is different from the stored session ID in 'verify' -->
                                    @if($session->SESS_ID != session('verify'))
                                        <div class="card m-5 rounded-5" style="width: 18rem;">
                                            {{ session(['verify' => $session->SESS_ID]) }}
                                            <div class="card-body">
                                                <h5 class="card-title">Prochaine Séance</h5>
                                                <div class="card-text">
                                                    <h4 class="fw-bold p-2 fs-4">
                                                        {{ strtoupper(\Carbon\Carbon::parse($session->SESS_DATE)->locale('fr')->translatedFormat('l')) }}
                                                        {{ \Carbon\Carbon::parse($session->SESS_DATE)->locale('fr')->translatedFormat('d F Y à H:i') }}
                                                    </h4>
                                                    <div class="shadow-sm p-2 bg-body-tertiary rounded">
                                                        <h4 class="fw-bold p-2 fs-6">Initateur:&nbsp;{{$session->USER_FIRSTNAME}} {{$session->USER_LASTNAME}}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @elseif(isset($sessions))
                    @foreach($sessions->chunk(4) as $index => $chunk)
                        <div class="carousel-item @if($index == 0) active @endif">
                            <div class="d-flex justify-content-center">
                                @foreach($chunk as $session)
                                    <!-- Check if the session ID is different from the stored session ID in 'verify' -->
                                    @if($session->SESS_ID != session('verify'))
                                        <div class="card m-5 rounded-5" style="width: 18rem;">
                                            {{ session(['verify' => $session->SESS_ID]) }}
                                            <div class="card-body">
                                                <h5 class="card-title">Prochaine Séance</h5>
                                                <div class="card-text">
                                                    <h4 class="fw-bold p-2 fs-4">
                                                        {{ strtoupper(\Carbon\Carbon::parse($session->SESS_DATE)->locale('fr')->translatedFormat('l')) }}
                                                        {{ \Carbon\Carbon::parse($session->SESS_DATE)->locale('fr')->translatedFormat('d F Y à H:i') }}
                                                    </h4>
                                                    <div class="shadow-sm p-2 bg-body-tertiary rounded">
                                                        <h4 class="fw-bold p-2 fs-6">Initateur:&nbsp;{{$initiator->USER_FIRSTNAME}} {{$initiator->USER_LASTNAME}}</h4>
                                                        @if(isset($abilities) && isset($session))
                                                        <h4 class="fw-bold p-2 fs-6">Niveau :&nbsp;{{$session->LEVEL_ID}}</h4>
                                                            <div class="shadow-sm p-2 bg-body-secondary rounded">
                                                                <h4 class="fw-bold p-2 fs-6">Compétence C{{$session->SKILL_ID}} : </h4><p class="p-2 fs-6"> {{$session->SKILL_LABEL}}</p>
                                                                <div class="shadow-sm p-2 bg-dark-subtle rounded">
                                                                    <!-- Display abilities related to this session -->
                                                                    @foreach($abilities as $ability)
                                                                        @if($ability->SESS_DATE == $session->SESS_DATE)
                                                                            <div>
                                                                                <!-- Display individual ability -->
                                                                                <h4 class="fw-bold d-inline p-2 fs-6"> A{{$ability->ABI_ID}} :</h4> <p class="d-inline p-2 fs-6"> {{$ability->ABI_LABEL}}<p>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
                
            </div>

            <!-- Carousel navigation buttons -->
            <button class="carousel-control-prev" type="button" data-bs-target="#sessionsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#sessionsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Suivant</span>
            </button>
        </div>
    </div>

    <script>
        // Initialize Bootstrap carousel with automatic wrapping to the first slide after the last
        document.addEventListener('DOMContentLoaded', function() {
            var carousel = new bootstrap.Carousel('#sessionsCarousel', {
                wrap:true // Revenir au premier slide après le dernier
            });
        });
    </script>

    <!-- Button to view progression -->
    <div class="d-flex justify-content-center">
        <a href='/sheet' class="col-lg-2"><button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary" type="button" data-dismiss="modal">Voir la progression</button>
    </div>

@endsection
