@extends('Base')

@section('title','Accueil')

@section('content')
<div>
    <!-- Loop through each club name and display the welcome message -->
    @foreach($clubName as $club)
        <!-- Title displaying the club name with a dolphin emoji -->
        <h2 class="text-center darkblue-text">Bienvenue sur <span> <strong>{{ $club }} </strong></span> 🐬</h2> 
    
        <!-- Main content container for the club description -->
        <div class="container py-5">
            <div class="card shadow border-0">
                <div class="card-body">
                    <!-- Description text about the club and its offerings -->
                    <p class="card-text">
                        Découvrez un monde sous-marin fascinant avec {{$club}} ! Situé au cœur d’une destination<strong> exceptionnelle</strong>, notre club de plongée s’adresse à tous, des débutants curieux aux plongeurs expérimentés en quête de nouvelles <strong>aventures</strong>.
                    </p>
                    <p class="card-text">
                        Plongez dans des eaux cristallines regorgeant de vie marine exceptionnelle et explorez des paysages subaquatiques <strong>inoubliables</strong> : récifs coralliens colorés, épaves historiques et espèces marines fascinantes. Nos moniteurs passionnés et <strong>certifiés</strong> vous accompagneront à chaque étape, en vous assurant une expérience sécurisée, enrichissante et adaptée à votre niveau.
                    </p>
                    <p class="card-text">
                        Que vous souhaitiez découvrir les bases de la <strong>plongée</strong>, perfectionner vos compétences grâce à des formations certifiées, nous avons tout ce qu’il faut pour rendre votre expérience inoubliable.
                    </p>
                    <p class="card-text">
                        En famille, entre amis ou en solo, rejoignez {{$club}} pour vivre des moments <strong>uniques</strong> sous l’eau et partager notre passion pour l’exploration marine. À bientôt sous la surface ! 🌊
                    </p>
                </div>
            </div>
        </div>
    
        <!-- Image grid section displaying four different images of marine life -->
        <div class="container">
            <div class="row g-3">
                <!-- First image (seal) with responsive design, cover style for fitting the image -->
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <img src="images/pexels-toulouse-3098971.jpg" class="img-fluid rounded" alt="Seal" style="object-fit: cover; height: 350px; width: 100%;">
                </div>
                <!-- Second image (ocean) with similar design properties -->
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <img src="images/pexels-pixabay-68767.jpg" class="img-fluid rounded" alt="Ocean" style="object-fit: cover; height: 350px; width: 100%;">
                </div>
                <!-- Third image (turtle) with the same responsive and object-fit styling -->
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <img src="images/turtle.jfif" class="img-fluid rounded" alt="Turtle" style="object-fit: cover; height: 350px; width: 100%;">
                </div>
                <!-- Fourth image (ray) with consistent styling and layout -->
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <img src="images/ray.jfif" class="img-fluid rounded" alt="Ray" style="object-fit: cover; height: 350px; width: 100%;">
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
