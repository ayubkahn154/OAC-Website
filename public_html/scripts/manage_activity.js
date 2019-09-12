// Get data from encoded JSON
document.getElementById('insert_activity').addEventListener("click", () => {
    location.href= "insert_activity.php?mode=add";
});

let data = JSON.parse(document.getElementById('data').innerHTML);

// DEBUG ONLY: uncomment following 2 lines to show JSON data on screen
// let str = JSON.stringify(data, null, 2);
// document.getElementById("MyTable").appendChild(document.createElement("pre")).innerText = str;

// Convert PHP dates to JS dates
for (let i = 0; i < data.length; i++) {
    let item = data[i];
    for (let j = 0; j < item.dates.length; j++) {
        item.dates[j] = new Date(item.dates[j]);
    }
}

// 👇 This will be used for printing out month names corresponding to JS function's getMonth() function
let months = Object.freeze(
    [
        "Jan", "Feb", "Mar",
        "Apr", "May", "Jun",
        "Jul", "Aug", "Sep",
        "Oct", "Nov", "Dec"
    ]
);

let monthSelector = undefined;
let categorySelector = undefined;
let streamSelector = undefined;
let citySelector = undefined;

// To preserve original data. Every time data is re-filtered or filters are cleared,
// original data is assigned to newData to maintain data integrity.
let originalData = data;
let newData = originalData;



function removeActivity(ID){
        let confirmThis = confirm("Are you sure, you want to delete this activity?");
        location.href =
            (confirmThis) ?
                "insert_activity.php?mode=delete&ID=" + ID :
                "manage_activity.php";
}

function editActivity(ID){
    location.href= "insert_activity.php?mode=edit&ID="+ID;
}

function updateData(newData) {
    const table = document.getElementById("MyTable");

    // Remove existing newData
    while(table.rows.length > 1)
        table.deleteRow(-1);

    // Insert new newData
    for (let i = 0; i < newData.length; i++) {
        // For ease of accessing newData, we create a temporary element
        let item = newData[i];

        let row = table.tBodies[0].insertRow();
        row.insertCell(-1).innerHTML = `<a class="button" onclick="removeActivity(${item.ID_encrypt})"><i class="fas fa-trash"></i></a>`;
        row.insertCell(-1).innerHTML = `<a class="button" onclick="editActivity(${item.ID_encrypt})"><i class="fas fa-edit"></i></a>`;
        row.insertCell(-1).innerText = item.organization;
        row.insertCell(-1).innerText = item.activity;
        row.insertCell(-1).innerText = item.stream;
        row.insertCell(-1).innerText = item.category;
        row.insertCell(-1).innerText = item.user_name;
        row.insertCell(-1).innerText = item.user_email;

        let datesHTML = "";
        for (let i = 0; i < item.dates.length; i++) {
            datesHTML += `${item.dates[i].getDate()} ${months[item.dates[i].getMonth()]} ${item.dates[i].getFullYear()} | ${item.start_time[i]} - ${item.end_time[i]}<br>`;
        }
        let dateCell = row.insertCell(-1);
        dateCell.innerHTML = datesHTML;
        dateCell.style.fontFamily = "monospace";
        dateCell.style.whiteSpace = "nowrap";
        dateCell.style.fontSize = "1.25rem";

    }
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
