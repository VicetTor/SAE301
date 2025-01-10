@extends('Base')

@section('title','Modification Site')

@section('content')

    <!-- Main section containing the form for modifying the website details -->
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card connexion-card text-black">
                        <div class="card-body p-5 text-center">
                            <!-- Title of the form -->
                            <h1 class="fw-bold mb-5">Modification site</h1> <!-- French: Modify Site -->

                            <!-- Form to update site details -->
                            <form method="POST" action="{{ route('site.update') }}" enctype="multipart/form-data">
                            @csrf    
                            
                            <!-- Input field for the website name -->
                            <div class="mb-3">
                                <label for="inputWebsiteName" class="form-label">Nom du site</label> <!-- French: Site Name -->
                                <input type="text" class="form-control" id="inputWebsiteName1" name="site_name" value="{{ old('site_name', $siteName) }}">
                            </div>

                            <!-- Input field for the website color -->
                            <div class="mb-3">
                                <label for="exampleColorInput" class="form-label">Couleur du site</label> <!-- French: Website Color -->
                                <div class="d-flex justify-content-center">
                                    <input type="color" class="form-control form-control-color" id="exampleColorInput" name="site_color" value="{{ old('site_color', $siteColor) }}" title="Choisissez votre couleur"> <!-- French: Choose your color -->
                                </div>
                            </div>

                            <!-- Input field for uploading the site logo -->
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Logo du site</label> <!-- French: Site Logo -->
                                <input class="form-control" type="file" id="formFile" name="site_logo">
                            </div>

                            <!-- Submit button to confirm the changes -->
                            <button type="submit" class="btn darkblue-bg">Confirmer</button> <!-- French: Confirm -->

                            </form>

                            <!-- Error message display if something fails -->
                            @if(session('fail') == 1)
                                <p> Erreur </p> <!-- French: Error -->
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Script to change the website color dynamically -->
    <script>
        document.getElementById('exampleColorInput').addEventListener('input', function(e) {
            var newColor = e.target.value;
            document.documentElement.style.setProperty('--site-color', newColor); // Update CSS variable with the selected color
        });
    </script>

@endsection
