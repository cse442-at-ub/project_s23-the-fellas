document.addEventListener('DOMContentLoaded', function () {
    const eventListItems = document.querySelectorAll('.event-list li');
    const eventModal = document.getElementById('eventInfoModal');
    const eventInfoTitle = document.getElementById('eventInfoTitle');
    const eventInfoDate = document.getElementById('eventInfoDate');
    const eventInfoColor = document.getElementById('eventInfoColor');
    const closeEventInfoModal = document.querySelector('.event-info-close');
    const eventInfoForm = document.getElementById('eventInfoForm');
    const eventInfoID = document.getElementById('eventInfoID');

    var dontOpen = false;
    //When you click on an event, the modal opens and the event info is displayed
    function updateEventListener(item) {
        item.addEventListener('click', function (event) {
                event.preventDefault();
                console.log(event)
                eventInfoTitle.value = this.innerText;
                eventInfoDate.value = this.getAttribute('data-date');
                eventInfoID.value = this.getAttribute('data-date-time');
                eventInfoColor.value = this.getAttribute('data-color').trim();
                console.log('x', this.getAttribute('data-color').trim(), 'x');
                eventModal.style.display = 'block';
            
        });
    }

    eventListItems.forEach(item => {
        updateEventListener(item);
    });
  
    //Sends the updatEvent action to the server (server.php) and updates the event in the database
    eventInfoForm.addEventListener('submit', function (event) {
        event.preventDefault();
  
        // Get the data from the form
        const title = (eventInfoTitle.value).toString();
        const dateTime = eventInfoDate.value.toString();
        const color = eventInfoColor.value.toString();
        const eventID = eventInfoID.value.toString();
        console.log(title, dateTime, color, eventID);
        console.log("submitted");
        fetch('server.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              action: 'updateEvent',
              title: title,
              dateTime: dateTime,
              color: color,
              eventID: eventID,
            })
        })
        .then(response => response.text())
        .then(data => {
            // Update the corresponding list item
            const listItem = document.getElementById(`event-item-${eventID}`);
            if (listItem) {
                listItem.innerText = title;
                listItem.setAttribute('data-date', dateTime);
                // Update other attributes if needed
                updateEventListener(listItem); // Update the event listener for the updated list item
            }
            // Close the modal after updating the event
            eventModal.style.display = 'none';
            location.reload();
        })
        .catch(error => {
            console.log(error);
            console.log(title, dateTime, color, eventID);
        });
    });
   //Delete Event
   //Sends the updatEvent action to the server (server.php) and updates the event in the database
   const deleteButton = document.getElementById("delete")
   if (deleteButton) {
    deleteButton.addEventListener('click', function(event) {
    event.preventDefault();

    // Get the data from the form
    const title = (eventInfoTitle.value).toString();
    const dateTime = eventInfoDate.value.toString();
    const color = eventInfoColor.value.toString();
    const eventID = eventInfoID.value.toString();
    // console.log(title, dateTime, color, eventID);
    // console.log("delete")
    fetch('server.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          action: 'deleteEvent',
          title: title,
          dateTime: dateTime,
          color: color,
          eventID: eventID,
        })
    })
    .then(response => {
        console.log("Resooinseewd")
        console.log(response.text());
    })
    .then(data => {
        // Update the corresponding list item
        const listItem = document.getElementById(`event-item-${eventID}`);
        if (listItem) {
            listItem.innerText = none;
            listItem.setAttribute('data-date', dateTime);
            // Update other attributes if needed
            updateEventListener(listItem); // Update the event listener for the updated list item
        }
        // Close the modal after updating the event
        eventModal.style.display = 'none';
        location.reload();
    })
    .catch(error => {
        console.log(error);
        console.log(title, dateTime, color, eventID);
    });
});
   }



    //When you click outside the modal or on the close button, the modal closes
    closeEventInfoModal.addEventListener('click', function () {
        eventModal.style.display = 'none';
    });
  
    //When u click ON the modal it will stay open and not close
    window.addEventListener('click', function (event) {
        if (event.target === eventModal) {
            eventModal.style.display = 'none';
        }
    });
});

function openDayModal(day, year, month, events, event) {
    console.log("Event: ", event.target);
    if (!event.target.classList.contains('day_num')) {
        return;
    }
    const dateStr = year + '-' + month.toString().padStart(2, '0') + '-' + day.toString().padStart(2, '0');
    const dayModal = document.getElementById("dayModal");
    const dayModalTitle = document.getElementById("dayModalTitle");
    const dayModalEvents = document.getElementById("dayModalEvents");
    
    // Set the modal title
    dayModalTitle.innerHTML = dateStr;
    
    // Clear any existing events
    dayModalEvents.innerHTML = "";
    
    // Add each event to the list
    events.forEach(event => {
        const li = document.createElement("li");
        li.innerHTML = event.title;
        dayModalEvents.appendChild(li);
    });
    
    // Display the modal
    dayModal.style.display = "block";
    
    // When the user clicks on the close button or outside the modal, close it
    const close = document.getElementsByClassName("close")[0];
    window.onclick = function(event) {
        if (event.target == dayModal || event.target == close) {
            dayModal.style.display = "none";
        }
    }
}

function print(thing) {
    console.log(thing);

}