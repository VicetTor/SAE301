Buttom = document.getElementById("button");

Buttom.addEventListener("click", addDiv)

function addDiv() {
    const newDiv = document.createElement("div");
    newDiv.classList.add("range");

const divStudent = document.createElement("div");
// Création de l'élément <select> avec les utilisateurs
const select = document.createElement("select");
select.classList.add("form-select");
select.style.width = "200px";
select.name = "user_id";
select.required = true;

// Ajouter une option par défaut
const defaultOption = document.createElement("option");
defaultOption.selected = true;
defaultOption.textContent = "Choix de l'élève";
select.appendChild(defaultOption);

// Ajouter les options pour chaque utilisateur
users.forEach(function(user) {
    const option = document.createElement("option");
    option.value = user.USER_ID; // Utiliser l'ID de l'utilisateur
    option.textContent = `${user.USER_FIRSTNAME} ${user.USER_LASTNAME}`; // Afficher le prénom + nom
    select.appendChild(option);
});

// Ajouter le <select> à la divStudent
divStudent.appendChild(select);

// Ajouter la divStudent au nouveau div
newDiv.appendChild(divStudent);

// Création des éléments Aptitude 1, 2 et 3
const divAptitude1 = document.createElement("div");
const selectAptitude1 = document.createElement("select");
selectAptitude1.classList.add("form-select");
selectAptitude1.style.width = "200px";
selectAptitude1.name = "aptitude_id_1";
selectAptitude1.required = true;

const defaultOptionAptitude1 = document.createElement("option");
defaultOptionAptitude1.selected = true;
defaultOptionAptitude1.textContent = "Choix des aptitudes";
selectAptitude1.appendChild(defaultOptionAptitude1);

// Remplir les options avec les aptitudes
aptitudes.forEach(function(aptitude) {
    const option = document.createElement("option");
    option.value = aptitude.Abi_id;  // ID de l'aptitude
    option.textContent = aptitude.Abi_label;  // Label de l'aptitude
    selectAptitude1.appendChild(option);
});

divAptitude1.appendChild(selectAptitude1);
newDiv.appendChild(divAptitude1);

// Création de l'élément Aptitude 2
const divAptitude2 = document.createElement("div");
const selectAptitude2 = document.createElement("select");
selectAptitude2.classList.add("form-select");
selectAptitude2.style.width = "200px";
selectAptitude2.name = "aptitude_id_2";
selectAptitude2.required = true;

const defaultOptionAptitude2 = document.createElement("option");
defaultOptionAptitude2.selected = true;
defaultOptionAptitude2.textContent = "Choix des aptitudes";
selectAptitude2.appendChild(defaultOptionAptitude2);

aptitudes.forEach(function(aptitude) {
    const option = document.createElement("option");
    option.value = aptitude.Abi_id;
    option.textContent = aptitude.Abi_label;
    selectAptitude2.appendChild(option);
});

divAptitude2.appendChild(selectAptitude2);
newDiv.appendChild(divAptitude2);


// Création de l'élément Aptitude 3
const divAptitude3 = document.createElement("div");
const selectAptitude3 = document.createElement("select");
selectAptitude3.classList.add("form-select");
selectAptitude3.style.width = "200px";
selectAptitude3.name = "aptitude_id_3";
selectAptitude3.required = true;

const defaultOptionAptitude3 = document.createElement("option");
defaultOptionAptitude3.selected = true;
defaultOptionAptitude3.textContent = "Choix des aptitudes";
selectAptitude3.appendChild(defaultOptionAptitude3);

aptitudes.forEach(function(aptitude) {
    const option = document.createElement("option");
    option.value = aptitude.Abi_id;
    option.textContent = aptitude.Abi_label;
    selectAptitude3.appendChild(option);
});

divAptitude3.appendChild(selectAptitude3);
newDiv.appendChild(divAptitude3);



const divInitiator = document.createElement("div");
// Création de l'élément Initiateur
const selectInitiator = document.createElement("select");
selectInitiator.classList.add("form-select");
selectInitiator.style.width = "200px";
selectInitiator.name = "initiator_id";
selectInitiator.required = true;

// Option par défaut
const defaultOptionInitiator = document.createElement("option");
defaultOptionInitiator.selected = true;
defaultOptionInitiator.textContent = "Choix de l'initiateur";
selectInitiator.appendChild(defaultOptionInitiator);

// Remplir les options avec les initiateurs
initiators.forEach(function(initiator) {
    const option = document.createElement("option");
    option.value = initiator.USER_ID;  // ID de l'initiateur
    option.textContent = initiator.USER_FIRSTNAME + ' ' + initiator.USER_LASTNAME;  // Nom et prénom de l'initiateur
    selectInitiator.appendChild(option);
});

divInitiator.appendChild(selectInitiator);
newDiv.appendChild(divInitiator);

newDiv.appendChild(divStudent);
newDiv.appendChild(divAptitude1);
newDiv.appendChild(divAptitude2);
newDiv.appendChild(divAptitude3);
newDiv.appendChild(divInitiator);

document.getElementById("addStudent").appendChild(newDiv);
}