@extends('Base')
@section('title','Page des séances')
<link href="../public/css/Session.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
@section('content')

    {{session(['verify' => '0'])}}
    <div class="seances">
        <h3> <strong> Mes Séances : </strong> </h3>

        <br>
        <div id="sessionsCarousel" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicateurs (points de navigation en bas) -->
            <div class="carousel-indicators">
                @foreach($sessions->chunk(4) as $index => $chunk)
                    <button type="button" data-bs-target="#sessionsCarousel" data-bs-slide-to="{{$index}}" class="@if($index == 0) active @endif" aria-current="true" aria-label="Slide {{$index + 1}}"></button>
                @endforeach
            </div>

            <!-- Contenu du carrousel -->
            <div class="carousel-inner">
                @foreach($sessions->chunk(4) as $index => $chunk)
                    <div class="carousel-item @if($index == 0) active @endif">
                        <div class="d-flex justify-content-center">
                            @foreach($chunk as $session)
                                @if($session->SESS_ID != session('verify'))
                                    <div class="card text-bg-light mb-3 rounded-5 p-3 back flex-column me-3 bg-body-secondary" style="max-width: 18rem;">
                                        {{ session(['verify' => $session->SESS_ID]) }}
                                        <div class="seance">
                                            <ul>
                                                <li><strong>Date de session</strong> : <br> {{$session->SESS_DATE}}</li>
                                            </ul>
                                            <ul>
                                                <li style="list-style: none"><strong>Niveau </strong>:&nbsp;{{$session->LEVEL_ID}}</li>
                                                <br>
                                                <li style="list-style: none"><strong>Compétence C{{$session->SKILL_ID}}</strong> : <br> {{$session->SKILL_LABEL}}</li>
                                            </ul>
                                            <div class="abilities">
                                                <ul>
                                                    @foreach($abilities as $ability)
                                                        <li style="list-style: none">
                                                            <span style="color: red"><strong>A{{$ability->ABI_ID}}</strong></span> : {{$ability->ABI_LABEL}}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Boutons de navigation -->
            <button class="carousel-control-prev" type="button" data-bs-target="#sessionsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#sessionsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Suivant</span>
            </button>

            <br>
            <div class="d-flex justify-content-center">
                <button data-mdb-button-init data-mdb-ripple-init class="col-lg-2 btn btn-primary" type="button" data-dismiss="modal">Voir la progression</button>
            </div>
        </div>
    </div>

            <script>
        document.addEventListener('DOMContentLoaded', function() {
            var carousel = new bootstrap.Carousel('#sessionsCarousel', {
                wrap:true // Revenir au premier slide après le dernier
            });
        });
    </script>


@endsection
