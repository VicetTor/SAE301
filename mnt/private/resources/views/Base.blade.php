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
    
    <script>

        function addDiv() {
            const newDiv = document.createElement("div");
            newDiv.classList.add("range");

        const divStudent = document.createElement("div");
        divStudent.innerHTML = `
            <p>Elève</p>
            <select class="form-select" style="width:200px">
                <option selected>choix de l'élève</option>
                <option value="1">Fabienne Jort</option>
                <option value="2">Catherine Poulain</option>
                <option value="3">Antoine Lanage</option>
                <option value="4">Didier Latortu</option>
                <option value="5">Stéphane Sefou</option>
            </select>
        `;

        const divAptitude1 = document.createElement("div");
        divAptitude1.innerHTML = `
            <p>Aptitude 1</p>
            <select class="form-select" style="width:200px">
                <option selected>Choix des aptitude</option>
                <option value="1">A1 : s'équilibrer</option>
                <option value="2">A2 : Respecter le millieu</option>
                <option value="3">A3 : S'immerger</option>
            </select>
        `;
        
        const divAptitude2 = document.createElement("div");
        divAptitude2.innerHTML = `
            <p>Aptitude 2</p>
            <select class="form-select" style="width:200px">
                <option selected>Choix des aptitude</option>
                <option value="1">A1 : s'équilibrer</option>
                <option value="2">A2 : Respecter le millieu</option>
                <option value="3">A3 : S'immerger</option>
            </select>
        `;

        const divAptitude3 = document.createElement("div");
        divAptitude3.innerHTML = `
            <p>Aptitude 3</p>
            <select class="form-select" style="width:200px">
                <option selected>Choix des aptitude</option>
                <option value="1">A1 : s'équilibrer</option>
                <option value="2">A2 : Respecter le millieu</option>
                <option value="3">A3 : S'immerger</option>
            </select>
        `;

        const divInitiator = document.createElement("div");
        divInitiator.innerHTML = `
            <p>Initiateur</p>
            <select class="form-select" style="width:200px">
                <option selected>Choix de l'Initiateur</option>
                <option value="1">Catherine Laroche</option>
                <option value="2">Pierre Cailloux</option>
                <option value="3">Jo Laucéan</option>
            </select>
        `;

    newDiv.appendChild(divStudent);
    newDiv.appendChild(divAptitude1);
    newDiv.appendChild(divAptitude2);
    newDiv.appendChild(divAptitude3);
    newDiv.appendChild(divInitiator);

    document.getElementById("addStudent").appendChild(newDiv);
}

    </script>
</body>
</html>