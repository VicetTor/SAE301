<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/css/app.css" rel="stylesheet">
    <title>Secoule : @yield('title')</title>
</head>
<body class="gray-bg body-base">
    <header>
         <nav class="navbar fixed-top darkblue-bg">
            <div class="container-fluid d-flex ">
                <a class="navbar-brand " href="#">
                    <img src="/images/FFESSM-Logo.png" alt="Logo de la FFESSM" width="56" height="56">
                </a>
                 <span class="navbar-text text-light fs-2">
                    @yield('navBarTitle')
                 </span>
                 <a class="navbar-brand" href="#">
                    <img src="/images/profile_icon.png" alt="Image de profil" width="56" height="56">
                </a>
            </div>
        </nav>
    </header>


    <div class="content margin-contain container shadow-sm p-3 mb-5 bg-body-tertiary rounded"> 
        @yield('content') 
    </div>


    <footer >
        <nav class="margin-footer navbar darkblue-bg sticky-bottom ">
            <div class="container-fluid d-block">
                
                <div class="text-center text-light">
                    <a class="fs-6 text-light" href="#">Mentions légales</a> -
                    <a class="fs-6 text-light" href="#">Conditions générales d'utilisation </a>-
                    <a class="fs-6 text-light" href="#">FAQ </a>-
                    <a class="fs-6 text-light" href="#">Contact </a>-
                    <a class="fs-6 text-light" href="#">Aide en ligne </a>-
                    <a class="fs-6 text-light" href="#">Ma FFESSM </a>

                </div>
                <br>
                <div class="text-center">
                    <a class="navbar-brand" href="#">
                        <img src="/images/ffessm-footer.png" alt="Logo de la FFESSM" width="56" height="56">
                    </a>
                    <a class="navbar-brand" href="#">
                        <img src="/images/instagram-icon.png" alt="Logo de la FFESSM" width="56" height="56">
                    </a>
                    <a class="navbar-brand" href="#">
                        <img src="/images/X-icon.png" alt="Logo de la FFESSM" width="56" height="56">
                    </a>
                    <a class="navbar-brand" href="#">
                        <img src="/images/facebook-icon.png" alt="Logo de la FFESSM" width="56" height="56">
                    </a>
                    <a class="navbar-brand" href="#">
                        <img src="/images/youtube-icon.png" alt="Logo de la FFESSM" width="56" height="56">
                    </a>
                </div>
            
            </div>
        </nav>
    </footer>
</body>
</html>