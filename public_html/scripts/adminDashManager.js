const ids = [
    "Activities", "Services", "Cities", "Streams", "Categories"
];

function addNewOrganization() {
    console.log("Function addNewOrganization() called.");
}

function addNewActivity() {
    console.log("Function addNewActivity() called.");
}

function addNewUser() {
    console.log("Function addNewUser() called.");
}

function addNewService() {
    console.log("Function addNewService() called.");
}

function addNewCity() {
    console.log("Function addNewCity() called.");
}

function addNewStream() {
    console.log("Function addNewStream() called.");
}

function addNewCategory() {
    console.log("Function addNewCategory() called.");
}

function revealContent(section) {
    // Un-select everything
    ids.forEach(id => {
        document.getElementById(id + "Tab").removeAttribute("class");
        document.getElementById(id + "Section").removeAttribute("class");
    });

    // Select the clicked section
    document.getElementById(section + "Tab").setAttribute("class", "selected");
    document.getElementById(section + "Section").setAttribute("class", "selected");
}

document.getElementById(ids[0] + "Tab").setAttribute("class", "selected");
document.getElementById(ids[0] + "Section").setAttribute("class", "selected");