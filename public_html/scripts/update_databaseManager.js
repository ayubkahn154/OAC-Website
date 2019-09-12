const ids = [
    "Services", "Support_Services", "Target", "Cities", "Streams", "Categories"
];

function addNewService() {
    console.log("Function addNewService() called.");
    addPrompt("Service", "services");
}

function addNewTarget() {
    console.log("Function addNewTarget() called.");
    addPrompt("Target", "target");
}

function addNewSupport_Service() {
    console.log("Function addNewSupport_Service() called.");
    addPrompt("Support Service", "support_service");
}

function addNewCity() {
    console.log("Function addNewCity() called.");
    addPrompt("City", "city");
}

function addNewStream() {
    console.log("Function addNewStream() called.");
    addPrompt("Stream", "stream");
}

function addNewCategory() {
    console.log("Function addNewCategory() called.");
    addPrompt("Category", "category");
}

function RemoveService(ID) {
    console.log("Function RemoveService() called.");
    removePrompt("Service", "services", ID);
}

function RemoveTarget(ID) {
    console.log("Function RemoveTarget() called.");
    removePrompt("Target", "target", ID);
}

function RemoveSupport_Service(ID) {
    console.log("Function RemoveSupport_Service() called.");
    removePrompt("Support Service", "support_service", ID);
}

function RemoveCity(ID) {
    console.log("Function RemoveCity() called.");
    removePrompt("City", "city", ID);
}

function RemoveStream(ID) {
    console.log("Function RemoveStream() called.");
    removePrompt("Stream", "stream", ID);
}

function RemoveCategory(ID) {
    console.log("Function RemoveCategory() called.");
    removePrompt("Category", "category", ID);
}

function addPrompt(str, table_name) {
    let prompt_result = prompt("Please enter the " + str + " you would like to add:");
    if(prompt_result)
        location.href = "update_database.php?mode=add&table=" + table_name + "&add="+prompt_result;
}

function removePrompt(str, table_name, ID) {
    let confirmDelete = confirm("Are you sure, you want to delete this " + str + "?");
    if(confirmDelete)
        location.href = "update_database.php?mode=delete&table=" + table_name + "&ID=" + ID;
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