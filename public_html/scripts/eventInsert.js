// additionalDates keeps track of all the dates
let additionalDates = 0;
let today = new Date();
const dateSet = document.querySelector("#multiDate");
const addDateButton = document.getElementById("addDateBtn");

function addDate(date, stime, etime) {

    // Update tracker
    additionalDates++;

    // Create Date input
    let newDate = document.createElement("input");
    newDate.setAttribute('type', 'date');
    newDate.setAttribute('name', 'event_date[]');
    newDate.setAttribute('id', 'Date' + additionalDates);
    newDate.setAttribute('min', today.getFullYear() + '-' + today.getMonth() + '-' + today.getDay());
    newDate.setAttribute('required', "true");
    newDate.setAttribute('onblur', 'verifyInfo()');
    if(date !== null)
        newDate.setAttribute('value', date);

    // Create Start time input
    let newStartTime = document.createElement("input");
    newStartTime.setAttribute('type', 'time');
    newStartTime.setAttribute('name', 'event_start_time[]');
    newStartTime.setAttribute('id', 'StartTime' + additionalDates);
    newStartTime.setAttribute('min', "08:00:00");
    newStartTime.setAttribute('max', "22:00:00");
    newStartTime.setAttribute('required', "true");
    newStartTime.setAttribute('onblur', 'verifyInfo()');
    if(stime !== null)
        newStartTime.setAttribute('value', stime);

    // Create End time input
    let newEndTime = document.createElement("input");
    newEndTime.setAttribute('type', 'time');
    newEndTime.setAttribute('name', 'event_end_time[]');
    newEndTime.setAttribute('id', 'EndTime' + additionalDates);
    newEndTime.setAttribute('min', "08:00:00");
    newEndTime.setAttribute('max', "22:00:00");
    newEndTime.setAttribute('required', "true");
    newEndTime.setAttribute('onblur', 'verifyInfo()');
    if(etime !== null)
        newEndTime.setAttribute('value', etime);

    // Create remove button
    let removeExtraDate = document.createElement("button");
    removeExtraDate.setAttribute('class', 'remove');
    // removeExtraDate.setAttribute('href', '');
    removeExtraDate.setAttribute('id', 'Date' + additionalDates + 'Remover');
    removeExtraDate.setAttribute('onclick', 'removeSet('+ additionalDates +')');
    removeExtraDate.innerText = "Remove Date/Time";

    // Add new row to set
    const newRow = dateSet.insertRow();
    newRow.setAttribute('id', 'DateTimeRow' + additionalDates);

    // Add new cell to row and add remove button
    let newCell = newRow.insertCell();
    newCell.appendChild(removeExtraDate);

    // Add new cell to row and add date input
    newCell = newRow.insertCell();
    newCell.appendChild(newDate);

    // Add new cell to row and add start time input
    newCell = newRow.insertCell();
    newCell.appendChild(newStartTime);

    // Add new cell to row and add end time input
    newCell = newRow.insertCell();
    newCell.appendChild(newEndTime);
}

 function verifyInfo() {
//     let dates = document.getElementsByName("event_date[]");
//     let startTimes = document.getElementsByName("event_start_time[]");
//     let endTimes = document.getElementsByName("event_end_time[]");
//     let disableSubmit = false;
//
//     if(dates.length === 1) {
//         document.getElementById('submit').setAttribute('disabled', disableSubmit);
//         return;
//     }
//
//     for(let i = 0; i < dates.length; i++) {
//         for(let j = i + 1; j < dates.length; j++) {
//             let dt1 = new Date(dates[i].valueAsDate);
//             let dt2 = new Date(dates[j].valueAsDate);
//             let st1 = new Date(startTimes[i].valueAsDate);
//             let st2 = new Date(startTimes[j].valueAsDate);
//             let et1 = new Date(endTimes[i].valueAsDate);
//             let et2 = new Date(endTimes[j].valueAsDate);
//             if(dt1 === dt2) {
//                 if (st1 <= st2 && st2 <= et1) disableSubmit = true;
//                 if (st1 <= et2 && et2<= et1) disableSubmit = true;
//                 if (st2 < st1 && et1 < et2) disableSubmit = true;
//             }
//         }
//    }
//
//     if(disableSubmit) {
//         alert("Date and time overlap detected.");
//         document.getElementById('submit').setAttribute("disabled", "disabled");
//     }
//     else
//         if(document.getElementById('submit').hasAttribute('disabled'))
//             document.getElementById('submit').removeAttribute('disabled');
}

function removeSet(s) {
    // Get items by id
    let targetRow = document.getElementById('DateTimeRow' + s);
    let targetDate = document.getElementById('Date' + s);
    let targetStartTime = document.getElementById('StartTime' + s);
    let targetEndTime = document.getElementById('EndTime' + s);
    let targetRemoveButton = document.getElementById('Date' + s + 'Remover');

    // Remove required attribute
    targetDate.setAttribute('required', 'false');
    targetStartTime.setAttribute('required', 'false');
    targetEndTime.setAttribute('required', 'false');

    // Delete
    targetDate.parentNode.removeChild(targetDate);
    targetStartTime.parentNode.removeChild(targetStartTime);
    targetEndTime.parentNode.removeChild(targetEndTime);
    targetRemoveButton.parentNode.removeChild(targetRemoveButton);
    targetRow.parentNode.removeChild(targetRow);

    verifyInfo();
}

if(editData !== null) {
    /*
    0 = Date
    1 = Start Time
    2 = End Time
     */
    editData.forEach(editDataDate => addDate(editDataDate[0],editDataDate[1],editDataDate[2]));
}