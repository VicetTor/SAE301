<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/css/app.css" rel="stylesheet">
    <title>{{ $siteName }} : @yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <style>
        :root {
            --site-color: {{ $siteColor ?? '#005c8f' }}; /* Default value */
        }
    </style>
</head>

<body class="gray-bg body-base">
    <!-- Header with navigation bar -->
    <header>
        <nav class="navbar navbar-expand-lg fixed-top darkblue-bg">
            <div class="container-fluid d-flex ">
                <!-- Site logo -->
                <a class="navbar-brand" href="#">
                    @if(isset($siteLogo))
                        <img src="{{ $siteLogo }}" alt="Logo du site" width="56" height="56">
                    @else
                        <img src="{{ asset('images/site_logo/site_logo.png') }}" alt="Logo du site" width="56" height="56">
                    @endif
                </a>
                <!-- Navbar toggle button for mobile -->
                <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar menu -->
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item fs-5 margin-right"> <a class="nav-link active text-light" href="/"> Accueil </a> </li>
                        <?php
                        if (Session('type_id') == 4) {
                            echo '<li class="nav-item fs-5 margin-right"> <a class="nav-link active text-light" href="/formation-accueil">Formations </a> </li>';
                            echo '<li class="nav-item fs-5 margin-right"> <a class="nav-link active text-light" href="/sheet"> Bilan des formations </a> </li>';
                            echo '<li class="nav-item fs-5 margin-right"><a class="nav-link active text-light" href="/validate">Valider niveau</a></li>';
                            echo '<li class="nav-item fs-5 margin-right"> <a class="nav-link active text-light" href="/modification/users"> Modération </a> </li>';
                            echo '<li class="nav-item fs-5 margin-right"><a class="nav-link active text-light" href="/modifying">Personnaliser le site</a></li>';
                            echo '<li class="nav-item fs-5 margin-right"> <a class="nav-link active text-light" href="/select-year"> CSV </a> </li>';
                        }
                        if (Session('type_id') == 3) {
                            echo '<li class="nav-item fs-5 margin-right"> <a class="nav-link active text-light" href="/session/create"> Créer Séance </a> </li>';
                            echo '<li class="nav-item fs-5 margin-right"> <a class="nav-link active text-light" href="/sheet"> Bilan de ma formation </a> </li>';
                            echo '<li class="nav-item fs-5 margin-right"> <a class="nav-link active text-light" href="/students"> Liste des adhérents </a> </li>';
                            echo '<li class="nav-item fs-5 margin-right"> <a class="nav-link active text-light" href="/evaluations/search"> Historique des Evaluations </a> </li>';
                        }
                        if (Session('type_id') == 2) {
                            echo '<li class="nav-item fs-5 margin-right"> <a class="nav-link active text-light" href="/sheet"> Bilan des formations </a> </li>';
                            echo '<li class="nav-item fs-5 margin-right"> <a class="nav-link active text-light" href="/students"> Liste des élèves </a> </li>';
                        }
                        if (Session('type_id') == 1) {
                            echo '<li class="nav-item fs-5 margin-right"><a class="nav-link active text-light" href="/session">Mes Séances</a></li>';
                            echo '<li class="nav-item fs-5 margin-right"><a class="nav-link active text-light" href="/sheet">Mon bilan</a></li>';
                        }
                        ?>
                        <li class="nav-item d-block d-lg-none">
                            <a class="nav-link active text-light" href="/profile"> Profil </a>
                        </li>
                    </ul>
                    <span class="navbar-text text-light fs-2 d-none d-lg-block">
                        @yield('navBarTitle')
                    </span>
                </div>
                <!-- Profile icon for large screens -->
                <a class="navbar-brand d-none d-lg-block" href="/profile">
                    <img src="/images/profile_icon.png" alt="Image de profil" width="56" height="56">
                </a>
            </div>
        </nav>
    </header>

    <!-- Main content area -->
    <div class="content margin-contain container shadow-sm p-3 mb-5 bg-body-tertiary rounded">
        @yield('content')
    </div>

    <!-- Footer section with legal mentions and social links -->
    <footer>
        <nav class="margin-footer navbar darkblue-bg sticky-bottom ">
            <div class="container-fluid d-block">
                <div class="text-center text-light">
                    <a class="fs-6 text-light" href="https://ffessm.fr/mentions-legales">Mentions légales</a> -
                    <a class="fs-6 text-light" href="https://ffessm.fr/conditions-generales-d-utilisation">Conditions générales d'utilisation </a>-
                    <a class="fs-6 text-light" href="https://ffessm.fr/faq">FAQ </a>-
                    <a class="fs-6 text-light" href="https://ffessm.fr/contact">Contact </a>-
                    <a class="fs-6 text-light" href="https://support.ffessm.fr/">Aide en ligne </a>-
                    <a class="fs-6 text-light" href="https://maffessm.fr/">Ma FFESSM </a>
                </div>
                <br>
                <div class="text-center">
                    <a class="navbar-brand" href="https://ffessm.fr/">
                        <img src="/images/ffessm-footer.png" alt="Logo de la FFESSM" width="56" height="56">
                    </a>
                    <a class="navbar-brand" href="https://www.instagram.com/ffessm_officiel/">
                        <img src="/images/instagram-icon.png" alt="Logo Instagram" width="56" height="56">
                    </a>
                    <a class="navbar-brand" href="https://x.com/FFESSM_Off?mx=2">
                        <img src="/images/X-icon.png" alt="Logo X" width="56" height="56">
                    </a>
                    <a class="navbar-brand" href="https://www.facebook.com/Ffessm/">
                        <img src="/images/facebook-icon.png" alt="Logo Facebook" width="56" height="56">
                    </a>
                    <a class="navbar-brand" href="https://www.youtube.com/channel/UCJsqq4c8lyL_Q3Olw5EwDQQ?cbrd=1">
                        <img src="/images/youtube-icon.png" alt="Logo Youtube" width="56" height="56">
                    </a>
                </div>
            </div>
        </nav>
    </footer>

</body>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

</html>
