
const add_org= document.getElementById('add_org');
const edit_org = document.getElementById('delete_org');


if(add_org) {
    add_org.addEventListener("click", function () {
        location.href = "add_organization.php?mode=add";

    });
}

    if(edit_org) {
        edit_org.addEventListener("click", function () {
            let orga_id = "";

            let org = document.getElementById("Organization");
            orga_id = org.options[org.selectedIndex].value;
            if (orga_id === "") {
                alert("Please select an organization and try again!");
                return;
            }
            let confirmThis = confirm('This will delete everything related to this Organization. Are you sure you want to delete this organization?');
            if (confirmThis) {
                location.href = "add_organization.php?mode=delete&orga_id=" + orga_id;
            }
        });
    }


    document.getElementById('edit_org').addEventListener("click",  function () {
    let orga_id = "";
    let org = document.getElementById("Organization");
    orga_id = org.options[org.selectedIndex].value;
    if (orga_id === "") {
        alert("Please select an organization and try again!");
        return;
    }
    location.href = "add_organization.php?mode=edit&orga_id=" + orga_id;
});

document.getElementById('add_non_ircc').addEventListener("click", function (){
    let org_id="";

    let org = document.getElementById("org_id");
    org_id = org.value;
    if (org_id === "") {
        alert("Failed to retrieve your organization");
        return;
    }
    location.href = "additional_services.php?mode=add&org_id=" + org_id;

});

document.getElementById('edit_non_ircc').addEventListener("click", function (){
    let service=  "";
    let orga_id = "";
    let org = document.getElementById("org_id");
    org_id = org.value;
    let services = document.getElementById("organization_services");
    service = services.options[services.selectedIndex].value;
    if (service === "") {
        alert("Please select the service you would like to edit and try again!");
        return;
    }
    location.href = "additional_services.php?mode=edit&org_id=" + org_id + "&service_id=" + service;

});

document.getElementById('remove_non_ircc').addEventListener("click", function (){
    let service=  "";
    let services = document.getElementById("organization_services");
    service = services.options[services.selectedIndex].value;
    if (service === "") {
        alert("Please select the service you would like to delete and try again!");
        return;
    }
    let confirmThis = confirm('Are you absolutely sure you want to delete this service?');
    if (confirmThis) {
        location.href = "additional_services.php?mode=delete&service_id=" + service;
    }
});
// // }
// document.getElementById('enable_non_ircc').addEventListener("click", function (){
//     let org_id = "";
//
//     let org = document.getElementById("organization_services");
//     orga_id=org.options(org.selectedIndex).value;
//     if (orga_id === "") {
//         alert("Please select an organization and try again!");
//         return;
//     }
//     let confirmThis = confirm('Are you absolutely sure you want to add this organization?');
//     if (confirmThis) {
//         location.href = "logic_additional_services.php?mode=enable&orga_id=" + orga_id;
//     }
// });}