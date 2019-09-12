/*
Strategy to maintain data integrity:

1.  Call the updateData() function with the default data to populate the table.
2.  Whenever a filter value is changed, call the filterUpdate function and get value.
3.  Set value to respective variable.
4.  Call the createFilteredData() function and filter data out of the main data.
5.  Call the updateData() function with the filtered data as parameter.
6.  If "Clear Filters" button is pressed, clear all filters and call updateData() with default data.

 */

const months = Object.freeze(
    [
        "January", "February", "March",
        "April", "May", "June",
        "July", "August", "September",
        "October", "November", "December"
    ]
);

// Selectors for filters. Whenever a filter value changes, one of these will change.
let monthSelector = undefined;
let categorySelector = undefined;
let streamSelector = undefined;
let citySelector = undefined;

// To preserve original data. Every time data is re-filtered or filters are cleared,
// original data is used to maintain data integrity.
let originalData = data;
let newData = originalData;

// Initial call to updateData() function to create data on screen using original data.
updateData(newData);

// This function creates entries in the events table, and
// populates divs to create clickable activities.
function updateData(newData) {
    const table = document.querySelector("#eventsTable");
    let isMaroon = true;
    let currentStream = "";

    // Remove existing newData
    while (table.hasChildNodes()) {
        table.removeChild(table.firstChild);
    }

    // If stream has not been filtered, sort data by stream
    if (streamSelector === undefined) {
        data.sort((a, b) => {
            let streamA = a.stream.toUpperCase();
            let streamB = b.stream.toUpperCase();

            if (streamA < streamB) return -1;
            if (streamA > streamB) return 1;

            return 0;
        });
    }

    // Insert new newData
    for (let i = 0; i < newData.length; i++) {
        // For ease of accessing newData, we create a temporary element
        let item = newData[i];

        // Create a div for table rows
        let newRow = document.createElement("div");
        newRow.setAttribute('id', 'row' + i);
        newRow.setAttribute('class', 'eventRow');
        // If isMaroon is true, the activity div will be maroon.
        // Else, it will be brown
        newRow.classList.add(isMaroon ? "maroon" : "brown");

        // If it is maroon, make it brown.
        isMaroon = !isMaroon;

        // Create divs for content and spacing inside the row
        let info = document.createElement("div");
        let categoryBox = document.createElement("div");
        info.setAttribute('class', 'info');
        categoryBox.setAttribute('class', 'categoryBox');

        info.innerText = `${item.activity} by ${item.organization}`;
        categoryBox.appendChild(document.createElement("span")).innerText = `${item.category}`;

        // Add onclick to the row
        newRow.setAttribute('onclick', 'openModal(' + i + ')');

        // Add divs to row
        newRow.appendChild(info);
        newRow.appendChild(categoryBox);

        // If stream is unfiltered, add stream div
        if (streamSelector === undefined && currentStream !== item.stream) {
            let streamDiv = document.createElement("div");
            streamDiv.classList.add("stream");
            streamDiv.appendChild(document.createElement("span")).innerText = `${item.stream}`;
            table.appendChild(streamDiv);
            currentStream = item.stream;
        }
        table.appendChild(newRow);
    }
}

function openModal(i) {
    let item = newData[i];

    // Prepare modal window and title bar
    let modal = document.getElementById("modal");
    let streamTitle = document.getElementById("streamTitle");
    let modalCloseButton = document.getElementById("modalCloseButton");
    let modalTitle = document.getElementById("modalTitle");
    let modalContent = document.getElementById("modalContent");

    // Add information to top bar
    streamTitle.innerText = item.stream + ' / ' + item.category;
    modalTitle.innerText = item.activity + ' by ' + item.organization;

    // Prepare all other sub-elements
    // Prepare date box
    let dateBox = modalContent.appendChild(document.createElement("div"));
    dateBox.id = "dateTimesBox";
    dateBox.appendChild(document.createElement("h3")).innerText = "Dates and Times";
    let datesTable = dateBox.appendChild(document.createElement("table"));
    datesTable.classList.add("table-separators");
    datesTable.classList.add("red-header");
    let datesTableHeader = datesTable.appendChild(document.createElement("thead"));
    let datesTableBody = datesTable.appendChild(document.createElement("tbody"));

    // Prepare description box
    let descriptionBox = modalContent.appendChild(document.createElement("div"));
    descriptionBox.id = "descriptionBox";
    descriptionBox.appendChild(document.createElement("h3")).innerText = "Description";

    // Prepare services box
    let servicesBox = modalContent.appendChild(document.createElement("div"));
    servicesBox.id = "servicesBox";
    servicesBox.appendChild(document.createElement("h3")).innerText = "Services";

    // Prepare targets box
    let targetsBox = modalContent.appendChild(document.createElement("div"));
    targetsBox.id = "targetsBox";
    targetsBox.appendChild(document.createElement("h3")).innerText = "Targets";

    // Prepare address box
    let addressBox = modalContent.appendChild(document.createElement("div"));
    addressBox.id = "addressBox";
    addressBox.appendChild(document.createElement("h3")).innerText = "Address";

    // Prepare contacts box
    let contactBox = modalContent.appendChild(document.createElement("div"));
    contactBox.id = "contactBox";
    contactBox.appendChild(document.createElement("h3")).innerText = "Contact Info";

    // Add dates and times to date box
    let headerRow = datesTableHeader.insertRow();
    headerRow.insertCell().innerHTML = "<b>Date</b>";
    headerRow.insertCell().innerHTML = "<b>Start Time</b>";
    headerRow.insertCell().innerHTML = "<b>End Time</b>";

    for (let i = 0; i < item.dates.length; i++) {
        let newRow = datesTableBody.insertRow();
        newRow.insertCell().innerText = `${months[item.dates[i].getMonth()]} ${item.dates[i].getDate()}, ${item.dates[i].getFullYear()}`;
        newRow.insertCell().innerText = item.start_time[i];
        newRow.insertCell().innerText = item.end_time[i];
    }

    // If description is available, add to modal content
    if (item.description != null && item.description !== "") {
        descriptionBox.appendChild(document.createElement("p")).innerText = item.description;
    } else {
        descriptionBox.appendChild(document.createElement("p")).innerHTML = "<i>No description given.</i>";
    }

    // List out support services
    let servicesList = document.createElement("ul");
    item.support_services.forEach(service => {
        servicesList.appendChild(document.createElement("li")).innerText = service;
    });
    servicesBox.appendChild(servicesList);

    // List out targets if available
    let targetsList = document.createElement("ul");
    item.targets.forEach(target => {
        targetsList.appendChild(document.createElement("li")).innerText = target;
    });
    targetsBox.appendChild(targetsList);

    // Create and insert address into modal
    let address = addressBox.appendChild(document.createElement("address"));
    address.innerText =
        `${item.address},
        ${item.city} ON
        ${item.postal_code}`;

    // Add contact details
    let contactInfo = contactBox.appendChild(document.createElement("p"));
    let contactInfoHTML =
        `Name: ${item.contact_name}<br>`;
    if (item.ext)
        contactInfoHTML += `Phone: <a href="tel:${item.contact_number};ext=${item.ext}">${item.contact_number} ext. ${item.ext}</a><br>`;
    else
        contactInfoHTML += `Phone: <a href="tel:${item.contact_number}">${item.contact_number}</a><br>`;

    if (item.email)
        contactInfoHTML += `Email: <a href="mailto:${item.email}">${item.email}</a><br>`;

    if (item.fax)
        contactInfoHTML += `Fax: <a href="tel:${item.fax}">${item.fax}</a><br>`;

    if (item.website)
        contactInfoHTML += `Website: <a href="${item.website}">${item.website}</a><br>`;

    contactInfo.innerHTML = contactInfoHTML;

    // Add modal close action to close button, and clear all data on close
    modalCloseButton.addEventListener("click", function () {
        while (modalContent.hasChildNodes()) {
            modalContent.removeChild(modalContent.firstChild);
        }
        modal.style.display = 'none';
    });

    // Finally, show the modal
    modal.style.display = 'flex';

    // If user clicks on the modal window's background the modal closes
    // modal.addEventListener("click", function () {
    //     while (modalContent.hasChildNodes()) {
    //         modalContent.removeChild(modalContent.firstChild);
    //     }
    //     modal.style.display = 'none';
    // });
}

function createFilteredData() {
    let filteredData = originalData;

    if (monthSelector !== undefined)
        filteredData = filteredData.filter(item => {
            let includeInData = false;
            item.dates.forEach(date => {
                if (date.getMonth() === monthSelector)
                    includeInData = true;
            });
            return includeInData;
        });

    if (categorySelector !== undefined)
        filteredData = filteredData
            .filter(item => item.category === categorySelector);

    if (streamSelector !== undefined)
        filteredData = filteredData
            .filter(item => item.stream === streamSelector);

    if (citySelector !== undefined)
        filteredData = filteredData
            .filter(item => item.city === citySelector);

    return filteredData;
}

function filterData(obj, value) {

    if (obj.getAttribute('id') === "monthSelector")
        monthSelector = (value === "") ? undefined : Number(value);

    else if (obj.getAttribute('id') === "categorySelector")
        categorySelector = (value === "") ? undefined : value;

    else if (obj.getAttribute('id') === "streamSelector")
        streamSelector = (value === "") ? undefined : value;

    else if (obj.getAttribute('id') === "citySelector")
        citySelector = (value === "") ? undefined : value;

    newData = createFilteredData();
    updateData(newData);
}

function clearFilters() {
    let selectTags = document.getElementsByTagName("select");

    for (let i = 0; i < selectTags.length; i++) {
        selectTags[i].selectedIndex = 0;
    }

    monthSelector = undefined;
    categorySelector = undefined;
    streamSelector = undefined;
    citySelector = undefined;

    newData = originalData;
    updateData(newData);
}

// DEBUG ONLY: uncomment following 2 lines to show JSON data on screen
// let str = JSON.stringify(data, null, 2);
// document.querySelector("#eventsTable").appendChild(document.createElement("pre")).innerText = str;