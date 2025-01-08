Statut = document.getElementById("TYPE_ID");
LevelPrepa = document.getElementById("LEVEL_ID_RESUME");
LevelPrepaLable = document.getElementById("LEVEL_ID_LABEL");
Level = document.getElementById("LEVEL_ID");
Statut.addEventListener("change", (event) => {
    if(Statut.value == 1){
        LevelPrepa.hidden = true;
        LevelPrepaLable.hidden = true;

        clearLevel()

        var opt = document.createElement('option');
        opt.value = 5;
        opt.innerHTML = "MF " + 1;
        Level.appendChild(opt);

    }

    else if(Statut.value == 3){
        LevelPrepa.hidden = true;
        LevelPrepaLable.hidden = true;

        clearLevel()

        for(var i = 2 ; i < 4; i++){
            var opt = document.createElement('option');
            opt.value = i;
            opt.innerHTML = "Niveau " + i;
            Level.appendChild(opt);
        }

        var opt = document.createElement('option');
        opt.value = 5;
        opt.innerHTML = "MF " + 1;
        Level.appendChild(opt);

    }

    else {
        LevelPrepa.hidden = false;
        LevelPrepaLable.hidden = false;

        clearLevel()

        for(var i = 0 ; i < 3; i++){
            var opt = document.createElement('option');
            opt.value = i;
            opt.innerHTML = "Niveau " + i;
            Level.appendChild(opt);
        }

        checkLevel(Level.value);
    }
});

Level.addEventListener("change", (event) => {
    checkLevel(Level.value);
});



function checkLevel($valeur) {
    var min = 1, max = 3;
    clearLevelPrepa();
    for (var i = min; i<=max; i++){
        if(i > $valeur){
            var opt = document.createElement('option');
            opt.value = i;
            opt.innerHTML = "Niveau " + i;
            LevelPrepa.appendChild(opt);
        }
    }
}

function clearLevelPrepa() {
    while (LevelPrepa.firstChild != null) {
        LevelPrepa.removeChild(LevelPrepa.firstChild);
    }
}

function clearLevel() {
    while (Level.firstChild != null) {
        Level.removeChild(Level.firstChild);
    }
}

