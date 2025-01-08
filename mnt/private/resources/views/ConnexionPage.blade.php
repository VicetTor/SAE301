<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/css/app.css" rel="stylesheet">
    <title>Secoule : Connexion</title>
</head>

<body class="turtle-background">
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card connexion-card text-black">
                        <div class="card-body p-5 text-center">
                                <h1 class="fw-bold mb-5">CONNEXION</h1>
                                <form method="POST" action="">
                                @csrf    

                                    <div data-mdb-input-init class="mb-4">
                                        <label for="mail" class="form-label">Adresse mail</label>
                                        <input class="form-control form-control-lg" for="mail" name="email" type="email" id="email" value="" placeholder="exemple@mail.fr" required />
                                    </div>

                                    <div data-mdb-input-init class="mb-4">
                                        <label class="form-label" for="mdp">Mot de passe</label>
                                        <input class="form-control form-control-lg" type="password" id="password" name="password" placeholder="*****" AUTOCOMPLETE=OFF required />
                                    </div>
                                    <br>
                                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-light btn-outline-dark btn-lg px-5" type="submit" name="connexion">Connexion</button>
                                </form>
                                @if(session('fail') == 1)
                                    <p> Erreur </p>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    use Illuminate\Support\Facades\Session;
    Session::put('fail', 0);
    ?>
</body>

</html>