@extends('Base')

@section('title','Création séance')
@section('navBarTitle', "Création d'une séance")
@section('content')

<!-- ligne 1 -->

<div class="range">
    <div>    
    <p>Date</p>
        <select class="form-select" style="width:200px">
            <option selected>Sélectionner la date</option>
            <option value="1">8/01/2025</option>
            <option value="2">9/01/2025</option>
            <option value="3">10/01/2025</option>
        </select>
    </div>
    <div>
        <p>Heure</p>
        <select class="form-select" style="width:200px">
            <option selected>Sélectionner l'heure</option>
            <option value="1">6 h 00</option>
            <option value="2">10 h 00</option>
            <option value="3">15 h 00</option>
            <option value="4">20 h 00</option>
            <option value="5">22 h 00</option>
        </select>
    </div>
</div>
    
<!-- ligne 2 -->

<div class="range">
    <div> 
        <p>Elève</p>
        <select class="form-select" style="width:200px">
            <option selected>choix de l'élève</option>
            <option value="1">Fabienne Jort</option>
            <option value="2">Catherine Poulain</option>
            <option value="3">Antoine Lanage</option>
            <option value="4">Didier Latortu</option>
            <option value="5">Stéphane Sefou</option>
        </select>
    </div>
    <div> 
    <p>Aptitude</p>
    <select class="form-select" style="width:200px">
        <option selected>Choix des aptitude</option>
        <option value="1">A1 : s'équilibrer</option>
        <option value="2">A2 : Respecter le millieu</option>
        <option value="3">A3 : S'immerger</option>
    </select>
    </div>
    <div> 
    <p>Initiateur</p>
    <select class="form-select" style="width:200px">
        <option selected>Choix de l'Initiateur</option>
        <option value="1">Catherine Laroche</option>
        <option value="2">Pierre Cailloux</option>
        <option value="3">Jo Laucéan</option>
    </select>
    </div>
</div> 

   
<!-- ligne 3  -->

<div class="range">
    <div> 
        <p>Elève</p>
        <select class="form-select" style="width:200px">
            <option selected>choix de l'élève</option>
            <option value="1">Fabienne Jort</option>
            <option value="2">Catherine Poulain</option>
            <option value="3">Antoine Lanage</option>
            <option value="4">Didier Latortu</option>
            <option value="5">Stéphane Sefou</option>
        </select>
    </div>
    <div> 
    <p>Aptitude</p>
    <select class="form-select" style="width:200px">
        <option selected>Choix des aptitude</option>
        <option value="1">A1 : s'équilibrer</option>
        <option value="2">A2 : Respecter le millieu</option>
        <option value="3">A3 : S'immerger</option>
    </select>
    </div>
    <div> 
    <p>Initiateur</p>
    <select class="form-select" style="width:200px">
        <option selected>Choix de l'Initiateur</option>
        <option value="1">Catherine Laroche</option>
        <option value="2">Pierre Cailloux</option>
        <option value="3">Jo Laucéan</option>
    </select>
    </div>
</div> 

<div class="range">
<div> 
<button type="button" class="btn btn-outline-warning range">Retour</button>
</div>
<div> 
<button type="button" class="btn btn-outline-primary range">Valider</button>
</div>
</div> 

@endsection
