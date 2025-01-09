@extends('Base')

@section('title','Modification Site')

@section('content')

    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card connexion-card text-black">
                        <div class="card-body p-5 text-center">
                            <h1 class="fw-bold mb-5">Modification site</h1>
                            <form method="POST" action="{{ route('site.update') }}" enctype="multipart/form-data">
                            @csrf    
                            <div class="mb-3">
                                <label for="inputWebsiteName" class="form-label">Nom du site</label>
                                <input type="text" class="form-control" id="inputWebsiteName1" name="site_name" value="{{ old('site_name', $siteName) }}">
                            </div>
                            <div class="mb-3">
                                <label for="exampleColorInput" class="form-label">Couleur du site</label>
                                <div class="d-flex justify-content-center">
                                    <input type="color" class="form-control form-control-color" id="exampleColorInput" name="site_color" value="{{ old('site_color', $siteColor) }}" title="Choisissez votre couleur">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Logo du site</label>
                                <input class="form-control" type="file" id="formFile" name="site_logo">
                            </div>
                            <button type="submit" class="btn darkblue-bg">Confirmer</button>
                                
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

    <script>
        document.getElementById('exampleColorInput').addEventListener('input', function(e) {
            var newColor = e.target.value;
            document.documentElement.style.setProperty('--site-color', newColor);
        });
    </script>


@endsection
